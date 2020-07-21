<?php
namespace Yurun\Util\YurunHttp\Handler;

use Yurun\Util\YurunHttp;
use Yurun\Util\YurunHttp\Attributes;
use Yurun\Util\YurunHttp\Http\Psr7\Uri;
use Yurun\Util\YurunHttp\Http\Response;
use Yurun\Util\YurunHttp\FormDataBuilder;
use Yurun\Util\YurunHttp\Traits\THandler;
use Yurun\Util\YurunHttp\Traits\TCookieManager;
use Yurun\Util\YurunHttp\Http\Psr7\Consts\MediaType;

class Curl implements IHandler
{
    use TCookieManager, THandler;

    /**
     * 请求结果
     *
     * @var \Yurun\Util\YurunHttp\Http\Response
     */
    private $result;
    
    /**
     * curl 句柄
     * @var resource
     */
    private $handler;

    /**
     * 请求内容
     * @var \Yurun\Util\YurunHttp\Http\Request
     */
    private $request;

    /**
     * curl 请求结果
     * @var string
     */
    private $curlResult;
    
    /**
     * 保存到的文件的句柄
     * @var resource
     */
    private $saveFileFp;

    /**
     * 下载文件上时，header 写入的文件句柄
     *
     * @var resource
     */
    private $headerFileFp;

    /**
     * 接收的响应头
     *
     * @var array
     */
    private $receiveHeaders;

    /**
     * 代理认证方式
     */
    public static $proxyAuths = [
        'basic' =>  CURLAUTH_BASIC,
        'ntlm'  =>  CURLAUTH_NTLM
    ];

    /**
     * 代理类型
     */
    public static $proxyType = [
        'http'      =>  CURLPROXY_HTTP,
        'socks4'    =>  CURLPROXY_SOCKS4,
        'socks4a'   =>  6, // CURLPROXY_SOCKS4A
        'socks5'    =>  CURLPROXY_SOCKS5,
    ];

    /**
     * 本 Handler 默认的 User-Agent
     *
     * @var string
     */
    private static $defaultUA;

    public function __construct()
    {
        if(null === static::$defaultUA)
        {
            $version = curl_version();
            static::$defaultUA = sprintf('Mozilla/5.0 YurunHttp/%s Curl/%s', YurunHttp::VERSION, isset($version['version']) ? $version['version'] : 'unknown');
        }
        $this->initCookieManager();
    }

    /**
     * 关闭并释放所有资源
     *
     * @return void
     */
    public function close()
    {
        if($this->handler)
        {
            curl_close($this->handler);
            $this->handler = null;
        }
    }

    /**
     * 发送请求
     * @param \Yurun\Util\YurunHttp\Http\Request $request
     * @return void
     */
    public function send($request)
    {
        $this->request = $request;
        if(!$this->handler)
        {
            $this->handler = curl_init();
        }
        $files = $this->request->getUploadedFiles();
        $body = (string)$this->request->getBody();
        
        if(!empty($files))
        {
            $body = FormDataBuilder::build($body, $files, $boundary);
            $this->request = $this->request->withHeader('Content-Type', MediaType::MULTIPART_FORM_DATA . '; boundary=' . $boundary);
        }
        $this->buildCurlHandlerBase($this->request, $this->handler, $this->receiveHeaders, $this->saveFileFp, $this->headerFileFp);
        if([] !== ($queryParams = $this->request->getQueryParams()))
        {
            $this->request = $this->request->withUri($this->request->getUri()->withQuery(http_build_query($queryParams, '', '&')));
        }
        $uri = $this->request->getUri();
        $isLocation = false;
        $statusCode = 0;
        $redirectCount = 0;
        do{
            // 请求方法
            if($isLocation && in_array($statusCode, [301, 302, 303]))
            {
                $method = 'GET';
            }
            else
            {
                $method = $this->request->getMethod();
            }
            if('GET' !== $method)
            {
                $bodyContent = $body;
            }
            else
            {
                $bodyContent = false;
            }
            $this->buildCurlHandlerEx($this->request, $this->handler, $uri, $method, $bodyContent);
            $retry = $this->request->getAttribute(Attributes::RETRY, 0);
            for($i = 0; $i <= $retry; ++$i)
            {
                $this->receiveHeaders = [];
                $this->curlResult = curl_exec($this->handler);
                // 下载文件特别处理 header
                if($this->headerFileFp)
                {
                    fseek($this->headerFileFp, 0);
                    $length = curl_getinfo($this->handler, CURLINFO_HEADER_SIZE);
                    $this->curlResult = fread($this->headerFileFp, $length);
                }
                $this->result = $this->getResponse($this->request, $this->handler, $this->curlResult, !!$this->headerFileFp, $this->receiveHeaders);
                $statusCode = $this->result->getStatusCode();
                // 状态码为5XX或者0才需要重试
                if(!(0 === $statusCode || (5 === (int)($statusCode/100))))
                {
                    break;
                }
            }
            if($this->request->getAttribute(Attributes::FOLLOW_LOCATION, true) && ($statusCode >= 300 && $statusCode < 400) && '' !== ($location = $this->result->getHeaderLine('location')))
            {
                if(++$redirectCount <= ($maxRedirects = $this->request->getAttribute(Attributes::MAX_REDIRECTS, 10)))
                {
                    $isLocation = true;
                    $uri = $this->parseRedirectLocation($location, $uri);
                    continue;
                }
                else
                {
                    $this->result = $this->result->withErrno(-1)
                                                 ->withError(sprintf('Maximum (%s) redirects followed', $maxRedirects));
                }
            }
            break;
        }while(true);
        // 关闭保存至文件的句柄
        if(null !== $this->saveFileFp)
        {
            fclose($this->saveFileFp);
            $this->saveFileFp = null;
        }
        if(null !== $this->headerFileFp)
        {
            fclose($this->headerFileFp);
            $this->headerFileFp = null;
        }
    }

    /**
     * 构建基础 Curl Handler
     *
     * @param \Yurun\Util\YurunHttp\Http\Request $request
     * @param resource $handler
     * @return void
     */
    public function buildCurlHandlerBase(&$request, $handler, &$headers = null, &$saveFileFp = null, &$headerFileFp = null)
    {
        $options = [
            // 返回内容
            CURLOPT_RETURNTRANSFER  => true,
            // 返回header
            CURLOPT_HEADER          => true,
            // 保存cookie
            CURLOPT_COOKIEJAR       => 'php://memory',
        ];
        // 自动重定向
        $options[CURLOPT_MAXREDIRS] = $request->getAttribute(Attributes::MAX_REDIRECTS, 10);

        // 自动解压缩支持
        $acceptEncoding = $request->getHeaderLine('Accept-Encoding');
        if('' !== $acceptEncoding)
        {
            $options[CURLOPT_ENCODING] = $acceptEncoding;
        }
        else
        {
            $options[CURLOPT_ENCODING] = '';
        }
        curl_setopt_array($handler, $options);
        $this->parseSSL($request, $handler);
        $this->parseOptions($request, $handler, $headers, $saveFileFp, $headerFileFp);
        $this->parseProxy($request, $handler);
        $this->parseHeaders($request, $handler);
        $this->parseCookies($request, $handler);
        $this->parseNetwork($request, $handler);
    }

    /**
     * 构建扩展 Curl Handler
     *
     * @param \Yurun\Util\YurunHttp\Http\Request $request
     * @param resource $handler
     * @param \Yurun\Util\YurunHttp\Http\Psr7\Uri|null $uri
     * @param string|null $method
     * @param string|null $body
     * @return void
     */
    public function buildCurlHandlerEx(&$request, $handler, $uri = null, $method = null, $body = null)
    {
        if(null === $uri)
        {
            $uri = $request->getUri();
        }
        if(null === $method)
        {
            $method = $request->getMethod();
        }
        if(null === $body)
        {
            $body = (string)$request->getBody();
        }
        switch($request->getProtocolVersion())
        {
            case '1.0':
                $httpVersion = CURL_HTTP_VERSION_1;
                break;
            case '2.0':
                $ssl = 'https' === $uri->getScheme();
                if($ssl)
                {
                    $httpVersion = CURL_HTTP_VERSION_2TLS;
                }
                else
                {
                    $httpVersion = CURL_HTTP_VERSION_2;
                }
                break;
            default:
                $httpVersion = CURL_HTTP_VERSION_1_1;
        }
        $requestOptions = [
            CURLOPT_URL             =>  (string)$uri,
            CURLOPT_HTTP_VERSION    =>  $httpVersion,
        ];
        // 请求方法
        if($body && 'GET' !== $method)
        {
            $requestOptions[CURLOPT_POSTFIELDS] = $body;
        }
        $requestOptions[CURLOPT_CUSTOMREQUEST] = $method;
        curl_setopt_array($handler, $requestOptions);
    }

    /**
     * 接收请求
     * @return \Yurun\Util\YurunHttp\Http\Response
     */
    public function recv()
    {
        return $this->result;
    }

    /**
     * 获取响应对象
     *
     * @param \Yurun\Util\YurunHttp\Http\Request $request
     * @param resource $handler
     * @param string $curlResult
     * @param bool $isDownload
     * @param array $receiveHeaders
     * @return \Yurun\Util\YurunHttp\Http\Response
     */
    private function getResponse($request, $handler, $curlResult, $isDownload, $receiveHeaders)
    {
        // 分离header和body
        $headerSize = curl_getinfo($handler, CURLINFO_HEADER_SIZE);
        $headerContent = substr($curlResult, 0, $headerSize);
        $body = substr($curlResult, $headerSize);
        // PHP 7.0.0开始substr()的 string 字符串长度与 start 相同时将返回一个空字符串。在之前的版本中，这种情况将返回 FALSE 。
        if(false === $body)
        {
            $body = '';
        }

        // body
        $result = new Response($body, curl_getinfo($handler, CURLINFO_HTTP_CODE));

        // headers
        if($isDownload)
        {
            $rawHeaders = explode("\r\n\r\n", trim($headerContent));
            $requestCount = count($rawHeaders);
            if($requestCount > 0)
            {
                $headers = $this->parseHeaderOneRequest($rawHeaders[$requestCount - 1]);
                foreach($headers as $name => $value)
                {
                    $result = $result->withAddedHeader($name, $value);
                }
            }
        }
        else
        {
            $rawHeaders = implode('', $receiveHeaders);
            $headers = $this->parseHeaderOneRequest($rawHeaders);
            foreach($headers as $name => $value)
            {
                $result = $result->withAddedHeader($name, $value);
            }
        }
        
        // cookies
        $cookies = [];
        $count = preg_match_all('/set-cookie\s*:\s*([^\r\n]+)/i', $headerContent, $matches);
        for($i = 0; $i < $count; ++$i)
        {
            $cookieItem = $this->cookieManager->addSetCookie($matches[1][$i]);
            $cookies[$cookieItem->name] = (array)$cookieItem;
        }
        return $result->withRequest($request)
                      ->withCookieOriginParams($cookies)
                      ->withError(curl_error($handler))
                      ->withErrno(curl_errno($handler));
    }
    
    /**
     * parseHeaderOneRequest
     * @param string $piece 
     * @return array
     */
    private function parseHeaderOneRequest($piece)
    {
        $tmpHeaders =[];
        $lines = explode("\r\n", $piece);
        $linesCount = count($lines);
        //从1开始，第0行包含了协议信息和状态信息，排除该行
        for($i = 1; $i < $linesCount; ++$i)
        {
            $line = trim($lines[$i]);
            if(empty($line) || strstr($line, ':') == false)
            {
                continue;
            }
            list($key, $value) = explode(':', $line, 2);
            $key = trim($key);
            $value = trim($value);
            if(isset($tmpHeaders[$key]))
            {
                if(is_array($tmpHeaders[$key]))
                {
                    $tmpHeaders[$key][] = $value;
                }
                else
                {
                    $tmp = $tmpHeaders[$key];
                    $tmpHeaders[$key] = [
                        $tmp,
                        $value,
                    ];
                }
            }
            else
            {
                $tmpHeaders[$key] = $value;
            }
        }
        return $tmpHeaders;
    }

    /**
     * 处理加密访问
     * @return void
     */
    private function parseSSL(&$request, $handler)
    {
        if($request->getAttribute(Attributes::IS_VERIFY_CA, false))
        {
            curl_setopt_array($handler, [
                CURLOPT_SSL_VERIFYPEER    => true,
                CURLOPT_CAINFO            => $request->getAttribute(Attributes::CA_CERT),
                CURLOPT_SSL_VERIFYHOST    => 2,
            ]);
        }
        else
        {
            curl_setopt_array($handler, [
                CURLOPT_SSL_VERIFYPEER    => false,
                CURLOPT_SSL_VERIFYHOST    => 0,
            ]);
        }
        $certPath = $request->getAttribute(Attributes::CERT_PATH, '');
        if('' !== $certPath)
        {
            curl_setopt_array($handler, [
                CURLOPT_SSLCERT         => $certPath,
                CURLOPT_SSLCERTPASSWD   => $request->getAttribute(Attributes::CERT_PASSWORD),
                CURLOPT_SSLCERTTYPE     => $request->getAttribute(Attributes::CERT_TYPE, 'pem'),
            ]);
        }
        $keyPath = $request->getAttribute(Attributes::KEY_PATH, '');
        if('' !== $keyPath)
        {
            curl_setopt_array($handler, [
                CURLOPT_SSLKEY          => $keyPath,
                CURLOPT_SSLKEYPASSWD    => $request->getAttribute(Attributes::KEY_PASSWORD),
                CURLOPT_SSLKEYTYPE      => $request->getAttribute(Attributes::KEY_TYPE, 'pem'),
            ]);
        }
    }
    
    /**
     * 处理设置项
     * @return void
     */
    private function parseOptions(&$request, $handler, &$headers = null, &$saveFileFp = null, &$headerFileFp = null)
    {
        $options = $request->getAttribute(Attributes::OPTIONS, []);
        if(isset($options[CURLOPT_HEADERFUNCTION]))
        {
            $headerCallable = $options[CURLOPT_HEADERFUNCTION];
        }
        else
        {
            $headerCallable = null;
        }
        $headers = [];
        $options[CURLOPT_HEADERFUNCTION] = function($handler, $header) use($headerCallable, &$headers){
            $headers[] = $header;
            if($headerCallable)
            {
                $headerCallable($handler, $header);
            }
            return strlen($header);
        };
        curl_setopt_array($handler, $options);
        // 请求结果保存为文件
        if(null !== ($saveFilePath = $request->getAttribute(Attributes::SAVE_FILE_PATH)))
        {
            $last = substr($saveFilePath, -1, 1);
            if('/' === $last || '\\' === $last)
            {
                // 自动获取文件名
                $saveFilePath .= basename($this->url);
            }
            $saveFileFp = fopen($saveFilePath, $request->getAttribute(Attributes::SAVE_FILE_MODE, 'w+'));
            curl_setopt_array($handler, [
                CURLOPT_HEADER          => false,
                CURLOPT_RETURNTRANSFER  => false,
                CURLOPT_FILE            => $saveFileFp,
            ]);
        }
    }

    /**
     * 处理代理
     * @return void
     */
    private function parseProxy(&$request, $handler)
    {
        if($request->getAttribute(Attributes::USE_PROXY, false))
        {
            $type = $request->getAttribute(Attributes::PROXY_TYPE, 'http');
            curl_setopt_array($handler, [
                CURLOPT_PROXYAUTH    => self::$proxyAuths[$request->getAttribute(Attributes::PROXY_AUTH, 'basic')],
                CURLOPT_PROXY        => $request->getAttribute(Attributes::PROXY_SERVER),
                CURLOPT_PROXYPORT    => $request->getAttribute(Attributes::PROXY_PORT),
                CURLOPT_PROXYUSERPWD => $request->getAttribute(Attributes::PROXY_USERNAME, '') . ':' . $request->getAttribute(Attributes::PROXY_PASSWORD, ''),
                CURLOPT_PROXYTYPE    => 'socks5' === $type ? (defined('CURLPROXY_SOCKS5_HOSTNAME') ? CURLPROXY_SOCKS5_HOSTNAME : self::$proxyType[$type]) : self::$proxyType[$type],
            ]);
        }
    }
    
    /**
     * 处理headers
     * @return void
     */
    private function parseHeaders(&$request, $handler)
    {
        if(!$request->hasHeader('User-Agent'))
        {
            $request = $request->withHeader('User-Agent', $request->getAttribute(Attributes::USER_AGENT, static::$defaultUA));
        }
        curl_setopt($handler, CURLOPT_HTTPHEADER, $this->parseHeadersFormat($request));
    }
    
    /**
     * 处理成CURL可以识别的headers格式
     * @return array 
     */
    private function parseHeadersFormat($request)
    {
        $headers =[];
        foreach($request->getHeaders() as $name => $value)
        {
            $headers[] = $name . ':' . implode(',', $value);
        }
        return $headers;
    }

    /**
     * 处理cookie
     * @return void
     */
    private function parseCookies(&$request, $handler)
    {
        foreach($request->getCookieParams() as $name => $value)
        {
            $this->cookieManager->setCookie($name, $value);
        }
        $cookie = $this->cookieManager->getRequestCookieString($request->getUri());
        curl_setopt($handler, CURLOPT_COOKIE, $cookie);
    }
    
    /**
     * 处理网络相关
     * @return void
     */
    private function parseNetwork(&$request, $handler)
    {
        // 用户名密码处理
        $username = $request->getAttribute(Attributes::USERNAME);
        if(null != $username)
        {
            $userPwd = $username . ':' . $request->getAttribute(Attributes::PASSWORD, '');
        }
        else
        {
            $userPwd = '';
        }
        curl_setopt_array($handler, [
            // 连接超时
            CURLOPT_CONNECTTIMEOUT_MS       => $request->getAttribute(Attributes::CONNECT_TIMEOUT, 30000),
            // 总超时
            CURLOPT_TIMEOUT_MS              => $request->getAttribute(Attributes::TIMEOUT, 0),
            // 下载限速
            CURLOPT_MAX_RECV_SPEED_LARGE    => $request->getAttribute(Attributes::DOWNLOAD_SPEED),
            // 上传限速
            CURLOPT_MAX_SEND_SPEED_LARGE    => $request->getAttribute(Attributes::UPLOAD_SPEED),
            // 连接中用到的用户名和密码
            CURLOPT_USERPWD                 => $userPwd,
        ]);
    }

    /**
     * 连接 WebSocket
     *
     * @param \Yurun\Util\YurunHttp\Http\Request $request
     * @param \Yurun\Util\YurunHttp\WebSocket\IWebSocketClient $websocketClient
     * @return \Yurun\Util\YurunHttp\WebSocket\IWebSocketClient
     */
    public function websocket($request, $websocketClient = null)
    {
        throw new \RuntimeException('Curl Handler does not support WebSocket');
    }

    /**
     * 获取原始处理器对象
     *
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * 批量运行并发请求
     *
     * @param \Yurun\Util\YurunHttp\Http\Request[] $requests
     * @param float|null $timeout 超时时间，单位：秒。默认为 null 不限制
     * @return \Yurun\Util\YurunHttp\Http\Response[]
     */
    public function coBatch($requests, $timeout = null)
    {
        $this->checkRequests($requests);
        $mh = curl_multi_init();
        $curlHandlers = $recvHeaders = $saveFileFps = $headerFileFps = [];
        try {
            foreach($requests as $k => $request)
            {
                $curlHandler = curl_init();
                $recvHeaders[$k] = $saveFileFps[$k] = $headerFileFps[$k] = [];
                $this->buildCurlHandlerBase($request, $curlHandler, $recvHeaders[$k], $saveFileFps[$k], $headerFileFps[$k]);
                $files = $request->getUploadedFiles();
                $body = (string)$request->getBody();
                if(!empty($files))
                {
                    $body = FormDataBuilder::build($body, $files, $boundary);
                    $request = $request->withHeader('Content-Type', MediaType::MULTIPART_FORM_DATA . '; boundary=' . $boundary);
                }
                $this->buildCurlHandlerEx($request, $curlHandler, null, null, $body);
                curl_multi_add_handle($mh, $curlHandler);
                $curlHandlers[$k] = $curlHandler;
            }
            $running = null;
            $beginTime = microtime(true);
            // 执行批处理句柄
            do {
                curl_multi_exec($mh, $running);
                if($running > 0)
                {
                    if($timeout && microtime(true) - $beginTime >= $timeout)
                    {
                        break;
                    }
                    usleep(5000); // 每次延时 5 毫秒
                }
                else
                {
                    break;
                }
            } while (true);
            $result = [];
            foreach($requests as $k => $request)
            {
                $handler = $curlHandlers[$k];
                $isDownload = null !== $request->getAttribute(Attributes::SAVE_FILE_PATH);
                $receiveHeaders = $recvHeaders[$k];
                $curlResult = curl_multi_getcontent($handler);
                if($isDownload)
                {
                    if($headerFileFps[$k])
                    {
                        fseek($headerFileFps[$k], 0);
                        $length = curl_getinfo($curlHandlers[$k], CURLINFO_HEADER_SIZE);
                        $curlResult = fread($headerFileFps[$k], $length);
                    }
                }
                $result[$k] = $this->getResponse($request, $handler, $curlResult, $isDownload, $receiveHeaders);
            }
            return $result;
        } finally {
            foreach($curlHandlers as $curlHandler)
            {
                curl_multi_remove_handle($mh, $curlHandler);
                curl_close($curlHandler);
            }
            curl_multi_close($mh);
        }
    }

}
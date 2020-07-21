<?php
namespace Yurun\Util;

use Yurun\Util\YurunHttp\Attributes;
use Yurun\Util\YurunHttp\Http\Request;
use Yurun\Util\YurunHttp\Http\Psr7\UploadedFile;
use Yurun\Util\YurunHttp\Http\Psr7\Consts\MediaType;

class HttpRequest
{
    /**
     * 处理器
     *
     * @var \Yurun\Util\YurunHttp\Handler\IHandler
     */
    private $handler;

    /**
     * 需要请求的Url地址
     * @var string
     */
    public $url;

    /**
     * 发送内容，可以是字符串、数组（支持键值、Yurun\Util\YurunHttp\Http\Psr7\UploadedFile，其中键值会作为html编码，文件则是上传）
     * @var mixed
     */
    public $content;

    /**
     * `curl_setopt_array()`所需要的第二个参数
     * @var array
     */
    public $options =[];

    /**
     * 请求头
     * @var array
     */
    public $headers =[];

    /**
     * Cookies
     * @var array
     */
    public $cookies =[];

    /**
     * 失败重试次数，默认为0
     * @var int
     */
    public $retry = 0;

    /**
     * 是否使用代理，默认false
     * @var bool
     */
    public $useProxy = false;

    /**
     * 代理设置
     * @var array
     */
    public $proxy =[];

    /**
     * 是否验证证书
     * @var bool
     */
    public $isVerifyCA = false;

    /**
     * CA根证书路径
     * @var string
     */
    public $caCert;

    /**
     * 连接超时时间，单位：毫秒
     * @var int
     */
    public $connectTimeout = 30000;

    /**
     * 总超时时间，单位：毫秒
     * @var int
     */
    public $timeout = 30000;

    /**
     * 下载限速，为0则不限制，单位：字节
     * @var int
     */
    public $downloadSpeed;

    /**
     * 上传限速，为0则不限制，单位：字节
     * @var int
     */
    public $uploadSpeed;

    /**
     * 用于连接中需要的用户名
     * @var string
     */
    public $username;

    /**
     * 用于连接中需要的密码
     * @var string
     */
    public $password;

    /**
     * 请求结果保存至文件的配置
     * @var mixed
     */
    public $saveFileOption =[];

    /**
     * 是否启用重定向
     * @var bool
     */
    public $followLocation = true;

    /**
     * 最大重定向次数
     * @var int
     */
    public $maxRedirects = 10;

    /**
     * 证书类型
     * 支持的格式有"PEM" (默认值), "DER"和"ENG"
     * @var string
     */
    public $certType = 'pem';

    /**
     * 一个包含 PEM 格式证书的文件名
     * @var string
     */
    public $certPath = '';
    /**
     * 使用证书需要的密码
     * @var string
     */
    public $certPassword = null;

    /**
     * certType规定的私钥的加密类型，支持的密钥类型为"PEM"(默认值)、"DER"和"ENG"
     * @var string
     */
    public $keyType = 'pem';
    
    /**
     * 包含 SSL 私钥的文件名
     * @var string
     */
    public $keyPath = '';

    /**
     * SSL私钥的密码
     * @var string
     */
    public $keyPassword = null;

    /**
     * 请求方法
     *
     * @var string
     */
    public $method = 'GET';

    /**
     * Http 协议版本
     *
     * @var string
     */
    public $protocolVersion = '1.1';

    /**
     * 代理认证方式
     */
    public static $proxyAuths =[];

    /**
     * 代理类型
     */
    public static $proxyType =[];

    /**
     * 构造方法
     * @return mixed 
     */
    public function __construct()
    {
        $this->open();
    }

    /**
     * 析构方法
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * 打开一个新连接，初始化所有参数。一般不需要手动调用。
     * @return void
     */
    public function open()
    {
        $this->handler = YurunHttp::getHandler();
        $this->retry = 0;
        $this->headers = $this->options =[];
        $this->url = $this->content = '';
        $this->useProxy = false;
        $this->proxy = [
            'auth'    =>    'basic',
            'type'    =>    'http',
        ];
        $this->isVerifyCA = false;
        $this->caCert = null;
        $this->connectTimeout = 30000;
        $this->timeout = 30000;
        $this->downloadSpeed = null;
        $this->uploadSpeed = null;
        $this->username = null;
        $this->password = null;
        $this->saveFileOption =[];
    }

    /**
     * 关闭连接。一般不需要手动调用。
     * @return void
     */
    public function close()
    {
        $this->handler->close();
        $this->handler = null;
    }

    /**
     * 创建一个新会话，等同于new
     * @return static
     */
    public static function newSession()
    {
        return new static;
    }

    /**
     * 获取处理器
     *
     * @return \Yurun\Util\YurunHttp\Handler\IHandler
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * 设置请求地址
     * @param string $url 请求地址
     * @return static
     */
    public function url($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * 设置发送内容，requestBody的别名
     * @param mixed $content 发送内容，可以是字符串、数组
     * @return static
     */
    public function content($content)
    {
        return $this->requestBody($content);
    }

    /**
     * 设置参数，requestBody的别名
     * @param mixed $params 发送内容，可以是字符串、数组
     * @return static
     */
    public function params($params)
    {
        return $this->requestBody($params);
    }

    /**
     * 设置请求主体
     * @param mixed $requestBody 发送内容，可以是字符串、数组
     * @return static
     */
    public function requestBody($requestBody)
    {
        $this->content = $requestBody;
        return $this;
    }

    /**
     * 批量设置CURL的Option
     * @param array $options curl_setopt_array()所需要的第二个参数
     * @return static
     */
    public function options($options)
    {
        foreach($options as $key => $value)
        {
            $this->options[$key] = $value;
        }
        return $this;
    }

    /**
     * 设置CURL的Option
     * @param int $option 需要设置的CURLOPT_XXX选项
     * @param mixed $value 值
     * @return static
     */
    public function option($option, $value)
    {
        $this->options[$option] = $value;
        return $this;
    }

    /**
     * 批量设置请求头
     * @param array $headers 
     * @return static
     */
    public function headers($headers)
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    /**
     * 设置请求头
     * @param string $header 请求头名称
     * @param string $value 值
     * @return static
     */
    public function header($header, $value)
    {
        $this->headers[$header] = $value;
        return $this;
    }

    /**
     * 设置Accept
     * @param string $accept
     * @return static
     */
    public function accept($accept)
    {
        $this->headers['Accept'] = $accept;
        return $this;
    }

    /**
     * 设置Accept-Language
     * @param string $acceptLanguage
     * @return static
     */
    public function acceptLanguage($acceptLanguage)
    {
        $this->headers['Accept-Language'] = $acceptLanguage;
        return $this;
    }

    /**
     * 设置Accept-Encoding
     * @param string $acceptEncoding 
     * @return static
     */
    public function acceptEncoding($acceptEncoding)
    {
        $this->headers['Accept-Encoding'] = $acceptEncoding;
        return $this;
    }

    /**
     * 设置Accept-Ranges
     * @param string $acceptRanges 
     * @return static
     */
    public function acceptRanges($acceptRanges)
    {
        $this->headers['Accept-Ranges'] = $acceptRanges;
        return $this;
    }

    /**
     * 设置Cache-Control
     * @param string $cacheControl 
     * @return static
     */
    public function cacheControl($cacheControl)
    {
        $this->headers['Cache-Control'] = $cacheControl;
        return $this;
    }

    /**
     * 批量设置Cookies
     * @param array $cookies 键值对应数组
     * @return static
     */
    public function cookies($cookies)
    {
        $this->cookies = array_merge($this->cookies, $cookies);
        return $this;
    }

    /**
     * 设置Cookie
     * @param string $name 名称
     * @param string $value 值
     * @return static
     */
    public function cookie($name, $value)
    {
        $this->cookies[$name] = $value;
        return $this;
    }

    /**
     * 设置Content-Type
     * @param string $contentType 
     * @return static
     */
    public function contentType($contentType)
    {
        $this->headers['Content-Type'] = $contentType;
        return $this;
    }

    /**
     * 设置Range
     * @param string $range 
     * @return static
     */
    public function range($range)
    {
        $this->headers['Range'] = $range;
        return $this;
    }

    /**
     * 设置Referer
     * @param string $referer 
     * @return static
     */
    public function referer($referer)
    {
        $this->headers['Referer'] = $referer;
        return $this;
    }

    /**
     * 设置User-Agent
     * @param string $userAgent 
     * @return static
     */
    public function userAgent($userAgent)
    {
        $this->headers['User-Agent'] = $userAgent;
        return $this;
    }

    /**
     * 设置User-Agent，userAgent的别名
     * @param string $userAgent 
     * @return static
     */
    public function ua($userAgent)
    {
        return $this->userAgent($userAgent);
    }

    /**
     * 设置失败重试次数，状态码为5XX或者0才需要重试
     * @param string $retry 
     * @return static
     */
    public function retry($retry)
    {
        $this->retry = $retry < 0 ? 0 : $retry;   //至少请求1次，即重试0次
        return $this;
    }

    /**
     * 代理
     * @param string $server 代理服务器地址
     * @param int $port 代理服务器端口
     * @param string $type 代理类型，支持：http、socks4、socks4a、socks5
     * @param string $auth 代理认证方式，支持：basic、ntlm。一般默认basic
     * @return static
     */
    public function proxy($server, $port, $type = 'http', $auth = 'basic')
    {
        $this->useProxy = true;
        $this->proxy = [
            'server'    =>  $server,
            'port'      =>  $port,
            'type'      =>  $type,
            'auth'      =>  $auth,
        ];
        return $this;
    }

    /**
     * 代理认证
     *
     * @param string $username
     * @param string $password
     * @return static
     */
    public function proxyAuth($username, $password)
    {
        $this->proxy['username'] = $username;
        $this->proxy['password'] = $password;
    }

    /**
     * 设置超时时间
     * @param int $timeout 总超时时间，单位：毫秒
     * @param int $connectTimeout 连接超时时间，单位：毫秒
     * @return static
     */
    public function timeout($timeout = null, $connectTimeout = null)
    {
        if(null !== $timeout)
        {
            $this->timeout = $timeout;
        }
        if(null !== $connectTimeout)
        {
            $this->connectTimeout = $connectTimeout;
        }
        return $this;
    }

    /**
     * 限速
     * @param int $download 下载速度，为0则不限制，单位：字节
     * @param int $upload 上传速度，为0则不限制，单位：字节
     * @return static
     */
    public function limitRate($download = 0, $upload = 0)
    {
        $this->downloadSpeed = $download;
        $this->uploadSpeed = $upload;
        return $this;
    }

    /**
     * 设置用于连接中需要的用户名和密码
     * @param string $username 用户名
     * @param string $password 密码
     * @return static
     */
    public function userPwd($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        return $this;
    }

    /**
     * 保存至文件的设置
     * @param string $filePath 文件路径
     * @param string $fileMode 文件打开方式，默认w+
     * @return static
     */
    public function saveFile($filePath, $fileMode = 'w+')
    {
        $this->saveFileOption['filePath'] = $filePath;
        $this->saveFileOption['fileMode'] = $fileMode;
        return $this;
    }

    /**
     * 获取文件保存路径
     * @return string 
     */
    public function getSavePath()
    {
        return $this->saveFileOption['savePath'];
    }

    /**
     * 设置SSL证书
     * @param string $path 一个包含 PEM 格式证书的文件名
     * @param string $type 证书类型，支持的格式有”PEM”(默认值),“DER”和”ENG”
     * @param string $password 使用证书需要的密码
     * @return static
     */
    public function sslCert($path, $type = null, $password = null)
    {
        $this->certPath = $path;
        if(null !== $type)
        {
            $this->certType = $type;
        }
        if(null !== $password)
        {
            $this->certPassword = $password;
        }
        return $this;
    }

    /**
     * 设置SSL私钥
     * @param string $path 包含 SSL 私钥的文件名
     * @param string $type certType规定的私钥的加密类型，支持的密钥类型为”PEM”(默认值)、”DER”和”ENG”
     * @param string $password SSL私钥的密码
     * @return static
     */
    public function sslKey($path, $type = null, $password = null)
    {
        $this->keyPath = $path;
        if(null !== $type)
        {
            $this->keyType = $type;
        }
        if(null !== $password)
        {
            $this->keyPassword = $password;
        }
        return $this;
    }

    /**
     * 设置请求方法
     * @param string $method 
     * @return static
     */
    public function method($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * 处理请求主体
     * @param string|array $requestBody
     * @param string|null $contentType 内容类型，支持null/json，为null时不处理
     * @return array
     */
    protected function parseRequestBody($requestBody, $contentType)
    {
        $body = $files = [];
        if(is_string($requestBody))
        {
            $body = $requestBody;
        }
        else if(is_array($requestBody))
        {
            switch($contentType)
            {
                case 'json':
                    $body = json_encode($requestBody);
                    $this->header('Content-Type', MediaType::APPLICATION_JSON);
                    break;
                default:
                    foreach($requestBody as $k => $v)
                    {
                        if($v instanceof UploadedFile)
                        {
                            $files[$k] = $v;
                        }
                        else
                        {
                            $body[$k] = $v;
                        }
                    }
                    $body = http_build_query($body, '', '&');
            }
        }
        else
        {
            throw new \InvalidArgumentException('$requestBody only can be string or array');
        }
        return [$body, $files];
    }

    /**
     * 构建请求类
     *
     * @param string $url 请求地址，如果为null则取url属性值
     * @param array $requestBody 发送内容，可以是字符串、数组，如果为空则取content属性值
     * @param string|null $method 请求方法，GET、POST等
     * @param string|null $contentType 内容类型，支持null/json，为null时不处理
     * @return \Yurun\Util\YurunHttp\Http\Request
     */
    public function buildRequest($url = null, $requestBody = null, $method = null, $contentType = null)
    {
        if(null === $url)
        {
            $url = $this->url;
        }
        if(null === $method)
        {
            $method = $this->method;
        }
        list($body, $files) = $this->parseRequestBody(null === $requestBody ? $this->content : $requestBody, $contentType);
        $request = new Request($url, $this->headers, $body, $method);
        $request = $request->withUploadedFiles($files)
                            ->withCookieParams($this->cookies)
                            ->withAttribute('maxRedirects', $this->maxRedirects)
                            ->withAttribute('isVerifyCA', $this->isVerifyCA)
                            ->withAttribute('caCert', $this->caCert)
                            ->withAttribute('certPath', $this->certPath)
                            ->withAttribute('certPassword', $this->certPassword)
                            ->withAttribute('certType', $this->certType)
                            ->withAttribute('keyPath', $this->keyPath)
                            ->withAttribute('keyPassword', $this->keyPassword)
                            ->withAttribute('keyType', $this->keyType)
                            ->withAttribute('options', $this->options)
                            ->withAttribute('saveFilePath', isset($this->saveFileOption['filePath']) ? $this->saveFileOption['filePath'] : null)
                            ->withAttribute('useProxy', $this->useProxy)
                            ->withAttribute('username', $this->username)
                            ->withAttribute('password', $this->password)
                            ->withAttribute('connectTimeout', $this->connectTimeout)
                            ->withAttribute('timeout', $this->timeout)
                            ->withAttribute('downloadSpeed', $this->downloadSpeed)
                            ->withAttribute('uploadSpeed', $this->uploadSpeed)
                            ->withAttribute('followLocation', $this->followLocation)
                            ->withProtocolVersion($this->protocolVersion)
                            ;
        foreach($this->proxy as $name => $value)
        {
            $request = $request->withAttribute('proxy.' . $name, $value);
        }
        return $request;
    }

    /**
     * 发送请求，所有请求的老祖宗
     * @param string $url 请求地址，如果为null则取url属性值
     * @param array $requestBody 发送内容，可以是字符串、数组，如果为空则取content属性值
     * @param string|null $method 请求方法，GET、POST等
     * @param string|null $contentType 内容类型，支持null/json，为null时不处理
     * @return \Yurun\Util\YurunHttp\Http\Response
     */
    public function send($url = null, $requestBody = null, $method = null, $contentType = null)
    {
        $request = $this->buildRequest($url, $requestBody, $method, $contentType);
        return YurunHttp::send($request, $this->handler);
    }

    /**
     * 发送 Http2 请求不调用 recv()
     * @param string $url 请求地址，如果为null则取url属性值
     * @param array $requestBody 发送内容，可以是字符串、数组，如果为空则取content属性值
     * @param array $method 请求方法，GET、POST等
     * @param string|null $contentType 内容类型，支持null/json，为null时不处理
     * @return \Yurun\Util\YurunHttp\Http\Response
     */
    public function sendHttp2WithoutRecv($url = null, $requestBody = null, $method = 'GET', $contentType = null)
    {
        $request = $this->buildRequest($url, $requestBody, $method, $contentType)
                        ->withProtocolVersion('2.0')
                        ->withAttribute(Attributes::HTTP2_NOT_RECV, true);
        return YurunHttp::send($request, $this->handler);
    }

    /**
     * GET请求
     * @param string $url 请求地址，如果为null则取url属性值
     * @param array $requestBody 发送内容，可以是字符串、数组，如果为空则取content属性值
     * @return \Yurun\Util\YurunHttp\Http\Response 
     */
    public function get($url = null, $requestBody = null)
    {
        if(!empty($requestBody))
        {
            if(strpos($url, '?'))
            {
                $url .= '&';
            }
            else
            {
                $url .= '?';
            }
            $url .= http_build_query($requestBody, '', '&');
        }
        return $this->send($url,[], 'GET');
    }

    /**
     * POST请求
     * @param string $url 请求地址，如果为null则取url属性值
     * @param array $requestBody 发送内容，可以是字符串、数组，如果为空则取content属性值
     * @param string|null $contentType 内容类型，支持null/json，为null时不处理
     * @return \Yurun\Util\YurunHttp\Http\Response
     */
    public function post($url = null, $requestBody = null, $contentType = null)
    {
        return $this->send($url, $requestBody, 'POST', $contentType);
    }

    /**
     * HEAD请求
     * @param string $url 请求地址，如果为null则取url属性值
     * @param array $requestBody 发送内容，可以是字符串、数组，如果为空则取content属性值
     * @return \Yurun\Util\YurunHttp\Http\Response
     */
    public function head($url = null, $requestBody = null)
    {
        return $this->send($url, $requestBody, 'HEAD');
    }

    /**
     * PUT请求
     * @param string $url 请求地址，如果为null则取url属性值
     * @param array $requestBody 发送内容，可以是字符串、数组，如果为空则取content属性值
     * @param string|null $contentType 内容类型，支持null/json，为null时不处理
     * @return \Yurun\Util\YurunHttp\Http\Response
     */
    public function put($url = null, $requestBody = null, $contentType = null)
    {
        return $this->send($url, $requestBody, 'PUT', $contentType);
    }

    /**
     * PATCH请求
     * @param string $url 请求地址，如果为null则取url属性值
     * @param array $requestBody 发送内容，可以是字符串、数组，如果为空则取content属性值
     * @param string|null $contentType 内容类型，支持null/json，为null时不处理
     * @return \Yurun\Util\YurunHttp\Http\Response
     */
    public function patch($url = null, $requestBody = null, $contentType = null)
    {
        return $this->send($url, $requestBody, 'PATCH', $contentType);
    }

    /**
     * DELETE请求
     * @param string $url 请求地址，如果为null则取url属性值
     * @param array $requestBody 发送内容，可以是字符串、数组，如果为空则取content属性值
     * @param string|null $contentType 内容类型，支持null/json，为null时不处理
     * @return \Yurun\Util\YurunHttp\Http\Response
     */
    public function delete($url = null, $requestBody = null, $contentType = null)
    {
        return $this->send($url, $requestBody, 'DELETE', $contentType);
    }

    /**
     * 直接下载文件
     * @param string $fileName 保存路径，如果以 .* 结尾，则根据 Content-Type 自动决定扩展名
     * @param string $url 下载文件地址
     * @param array $requestBody 发送内容，可以是字符串、数组，如果为空则取content属性值
     * @param string $method 请求方法，GET、POST等，一般用GET
     * @return \Yurun\Util\YurunHttp\Http\Response
     */
    public function download($fileName, $url = null, $requestBody = null, $method = 'GET')
    {
        static $autoExtFlag = '.*';
        if($isAutoExt = (substr($fileName, -strlen($autoExtFlag)) === $autoExtFlag))
        {
            $basename = substr($fileName, 0, -2);
            $fileName = $basename . '.tmp';
        }
        $result = $this->saveFile($fileName)->send($url, $requestBody, $method);
        if($isAutoExt)
        {
            $ext = MediaType::getExt($result->getHeaderLine('Content-Type'));
            if(null === $ext)
            {
                $ext = 'file';
            }
            rename($fileName, $basename . '.' . $ext);
        }
        $this->saveFileOption =[];
        return $result;
    }

    /**
     * WebSocket
     *
     * @param string $url
     * @return \Yurun\Util\YurunHttp\WebSocket\IWebSocketClient
     */
    public function websocket($url = null)
    {
        $request = $this->buildRequest($url);
        return YurunHttp::websocket($request, $this->handler);
    }

}

if(extension_loaded('curl'))
{
    // 代理认证方式
    HttpRequest::$proxyAuths = [
        'basic' =>  CURLAUTH_BASIC,
        'ntlm'  =>  CURLAUTH_NTLM
    ];

    // 代理类型
    HttpRequest::$proxyType = [
        'http'      =>  CURLPROXY_HTTP,
        'socks4'    =>  CURLPROXY_SOCKS4,
        'socks4a'   =>  6,    // CURLPROXY_SOCKS4A
        'socks5'    =>  CURLPROXY_SOCKS5,
    ];
}

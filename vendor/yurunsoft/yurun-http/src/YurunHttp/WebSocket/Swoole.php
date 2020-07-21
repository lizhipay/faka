<?php
namespace Yurun\Util\YurunHttp\WebSocket;

use Yurun\Util\YurunHttp\Exception\WebSocketException;
use Yurun\Util\YurunHttp\Http\Psr7\Uri;

class Swoole implements IWebSocketClient
{
    /**
     * Http Request
     *
     * @var \Yurun\Util\YurunHttp\Http\Request
     */
    private $request;

    /**
     * Http Response
     *
     * @var \Yurun\Util\YurunHttp\Http\Response
     */
    private $response;

    /**
     * Handler
     *
     * @var \Swoole\Coroutine\Http\Client
     */
    private $handler;

    /**
     * Http Handler
     *
     * @var \Yurun\Util\YurunHttp\Handler\Swoole
     */
    private $httpHandler;

    /**
     * 连接状态
     *
     * @var boolean
     */
    private $connected = false;

    /**
     * 初始化
     *
     * @param \Yurun\Util\YurunHttp\Handler\Swoole $httpHandler
     * @param \Yurun\Util\YurunHttp\Http\Request $request
     * @param \Yurun\Util\YurunHttp\Http\Response $response
     * @return void
     */
    public function init($httpHandler, $request, $response)
    {
        $this->httpHandler = $httpHandler;
        $this->request = $request;
        $this->response = $response;
        $uri = $request->getUri();
        $this->handler = $this->httpHandler->getHttpConnectionManager()->getConnection($uri->getHost(), Uri::getServerPort($uri), 'https' === $uri->getScheme() || 'wss' === $uri->getScheme());
        $this->connected = true;
    }

    /**
     * 获取 Http Handler
     *
     * @return  \Yurun\Util\YurunHttp\Handler\IHandler
     */ 
    public function getHttpHandler()
    {
        return $this->httpHandler;
    }

    /**
     * 获取 Http Request
     *
     * @return \Yurun\Util\YurunHttp\Http\Request
     */
    public function getHttpRequest()
    {
        return $this->request;
    }

    /**
     * 获取 Http Response
     *
     * @return \Yurun\Util\YurunHttp\Http\Response
     */
    public function getHttpResponse()
    {
        return $this->response;
    }

    /**
     * 连接
     *
     * @return bool
     */
    public function connect()
    {
        $this->httpHandler->websocket($this->request, $this);
        return $this->isConnected();
    }

    /**
     * 关闭连接
     *
     * @return void
     */
    public function close()
    {
        $this->handler->close();
        $this->connected = true;
    }

    /**
     * 发送数据
     *
     * @param mixed $data
     * @return bool
     */
    public function send($data)
    {
        $result = $this->handler->push($data);
        if(!$result)
        {
            throw new WebSocketException(sprintf('Send Failed, error: %s, errorCode: %s', swoole_strerror($this->handler->errCode), $this->handler->errCode), $this->handler->errCode);
        }
        return $result;
    }

    /**
     * 接收数据
     *
     * @param double|null $timeout 超时时间，单位：秒。默认为 null 不限制
     * @return mixed
     */
    public function recv($timeout = null)
    {
        $result = $this->handler->recv($timeout);
        if(!$result)
        {
            return false;
        }
        return $result->data;
    }

    /**
     * 是否已连接
     *
     * @return boolean
     */
    public function isConnected()
    {
        return $this->connected;
    }

}

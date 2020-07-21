<?php
namespace Yurun\Util\YurunHttp\Handler\Swoole;

use Swoole\Coroutine\Http\Client;

class HttpConnectionManager extends BaseConnectionManager
{
    /**
     * 创建新连接，但不归本管理器管理
     *
     * @param string $host
     * @param int $port
     * @param bool $ssl
     * @return \Swoole\Coroutine\Http\Client
     */
    public function createConnection($host, $port, $ssl)
    {
        return new Client($host, $port, $ssl);
    }

}

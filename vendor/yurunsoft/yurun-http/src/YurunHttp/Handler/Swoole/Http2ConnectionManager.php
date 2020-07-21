<?php
namespace Yurun\Util\YurunHttp\Handler\Swoole;

use Swoole\Coroutine\Http2\Client;

class Http2ConnectionManager extends BaseConnectionManager
{
    /**
     * 创建新连接，但不归本管理器管理
     *
     * @param string $host
     * @param int $port
     * @param bool $ssl
     * @return \Swoole\Coroutine\Http2\Client
     */
    public function createConnection($host, $port, $ssl)
    {
        $client = new Client($host, $port, $ssl);
        if($client->connect())
        {
            return $client;
        }
        else
        {
            throw new \RuntimeException(sprintf('Http2 connect failed! errCode: %s, errMsg:%s', $client->errCode, swoole_strerror($client->errCode)));
        }
    }

}

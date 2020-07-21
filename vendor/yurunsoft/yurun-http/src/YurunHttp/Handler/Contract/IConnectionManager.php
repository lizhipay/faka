<?php
namespace Yurun\Util\YurunHttp\Handler\Contract;

interface IConnectionManager
{
    /**
     * 获取连接
     *
     * @param string $host
     * @param int $port
     * @param bool $ssl
     * @return mixed
     */
    public function getConnection($host, $port, $ssl);

    /**
     * 将指定连接从本管理器中移除，但不会关闭该连接
     *
     * @param string $host
     * @param int $port
     * @param bool $ssl
     * @return mixed|bool
     */
    public function removeConnection($host, $port, $ssl);

    /**
     * 关闭指定连接
     *
     * @param string $host
     * @param int $port
     * @param bool $ssl
     * @return bool
     */
    public function closeConnection($host, $port, $ssl);

    /**
     * 创建新连接，但不归本管理器管理
     *
     * @param string $host
     * @param int $port
     * @param bool $ssl
     * @return mixed
     */
    public function createConnection($host, $port, $ssl);

    /**
     * 关闭连接管理器
     *
     * @return void
     */
    public function close();

}

<?php
namespace Yurun\Util\YurunHttp\Co;

use Yurun\Util\YurunHttp;

abstract class Batch
{
    /**
     * 批量运行并发请求
     *
     * @param \Yurun\Util\YurunHttp\Http\Request[]|\Yurun\Util\HttpRequest[] $requests
     * @param float|null $timeout 超时时间，单位：秒。默认为 null 不限制
     * @param string|null $handlerClass
     * @return \Yurun\Util\YurunHttp\Http\Response[]
     */
    public static function run($requests, $timeout = null, $handlerClass = null)
    {
        foreach($requests as &$request)
        {
            if($request instanceof \Yurun\Util\HttpRequest)
            {
                $request = $request->buildRequest();
            }
            else if(!$request instanceof \Yurun\Util\YurunHttp\Http\Request)
            {
                throw new \InvalidArgumentException('Request must be instance of \Yurun\Util\YurunHttp\Http\Request or \Yurun\Util\HttpRequest');
            }
        }
        if(null === $handlerClass)
        {
            $handler = YurunHttp::getHandler();
        }
        else
        {
            $handler = new $handlerClass;
        }
        /** @var \Yurun\Util\YurunHttp\Handler\IHandler $handler */
        return $handler->coBatch($requests, $timeout);
    }

}

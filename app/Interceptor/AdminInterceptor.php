<?php
declare (strict_types=1);

namespace App\Interceptor;


use Core\Exception\ViewException;
use Core\PSR\InterceptorInterface;

/**
 * Class UserInterceptor
 * @package App\Interceptor
 */
class AdminInterceptor implements InterceptorInterface
{

    /**
     * @inheritDoc
     * @throws ViewException
     */
    public function handle(): void
    {
        $user = $_SESSION['login'];
        if (!$user) {
            throw new ViewException('您还未登录，请登录后在访问');
        }

        if ($user['time'] + 1800 < time()) {
            throw new ViewException('登录已过期，请重新登录');
        }

        //更新session
        $user['time'] = time();
        $_SESSION['login'] = $user;
    }
}
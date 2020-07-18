<?php
declare (strict_types=1);

namespace App\Interceptor;


use Core\Exception\JSONException;
use Core\PSR\InterceptorInterface;

/**
 * Class AdminApiInterceptor
 * @package App\Interceptor
 */
class AdminApiInterceptor implements InterceptorInterface
{

    /**
     * @inheritDoc
     * @throws JSONException
     */
    public function handle(): void
    {
        $user = $_SESSION['login'];
        if (!$user) {
            throw new JSONException('您还未登录，请登录后在访问');
        }

        if ($user['time'] + 1800 < time()) {
            throw new JSONException('登录已过期，请重新登录');
        }

        //更新session
        $user['time'] = time();
        $_SESSION['login'] = $user;
    }
}
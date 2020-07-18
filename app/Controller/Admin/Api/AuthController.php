<?php
declare (strict_types=1);

namespace App\Controller\Admin\Api;


use App\Controller\AdminApiBaseController;
use App\Utils\AddressUtil;
use App\Utils\DateUtil;
use App\Utils\StringUtil;
use Core\Exception\JSONException;
use Core\Utils\Bridge;

/**
 * Class AuthController
 * @package app\Controller\Admin\Api
 */
class AuthController extends AdminApiBaseController
{
    /**
     * @return array
     * @throws JSONException
     */
    public function login(): array
    {
        $username = (string)$_POST['user'];
        $pass = (string)$_POST['pass'];
        $user = Bridge::getConfig('user');

        if ($user['user'] != $username) {
            throw new JSONException('账号错误');
        }

        if (StringUtil::generatePassword($pass, $user['salt']) != $user['pass']) {
            throw new JSONException('密码错误');
        }

        //登录成功，设置SESSION
        $client = AddressUtil::getClient();
        $_SESSION['login'] = ['time' => time(), 'ip' => $client];
        Bridge::setConfig('user', ['time' => DateUtil::current(), 'ip' => $client]);
        return $this->json(200, '登录成功');
    }
}
<?php
declare (strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AdminBaseController;
use App\Utils\LocalUtil;

/**
 * Class AuthController
 * @package App\Controller\Admin
 */
class AuthController extends AdminBaseController
{


    /**
     * @return string
     * @throws \Core\Exception\RuntimeException
     */
    public function login()
    {
        //判断是否安装
        if (!file_exists(BASE_PATH . '/core/Install/lock')) {
            LocalUtil::redirect('/install/setup');
        }
        return $this->render('login', 'login.html');
    }

}
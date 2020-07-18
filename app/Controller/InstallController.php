<?php
declare (strict_types=1);

namespace App\Controller;


/**
 * Class InstallController
 * @package app\Controller
 */
class InstallController extends IndexBaseController
{
    /**
     * 安装界面
     * @throws \Core\Exception\RuntimeException
     */
    public function setup()
    {
        return $this->render('安装', 'install.html');
    }
}
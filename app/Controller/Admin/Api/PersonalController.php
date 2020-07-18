<?php
declare (strict_types=1);

namespace app\Controller\Admin\Api;


use App\Controller\AdminApiBaseController;
use App\Interceptor\AdminApiInterceptor;
use App\Utils\LocalUtil;
use App\Utils\StringUtil;
use Core\Utils\Bridge;

/**
 * Class PersonalController
 * @package app\Controller\Admin\Api
 * @Interceptor(AdminApiInterceptor::class)
 */
class PersonalController extends AdminApiBaseController
{
    /**
     * 设置资料
     * @return array
     */
    public function edit(): array
    {
        $map = $_POST;
        foreach ($map as $k => $v) {
            if ($v == '' || empty($v)) {
                unset($map[$k]);
            }
        }

        if ($map['pass']) {
            $map['salt'] = md5((string)time());
            $map['pass'] = StringUtil::generatePassword($map['pass'], $map['salt']);
        }
        Bridge::setConfig('user', $map);
        return $this->json(200, '修改成功');
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        session_destroy();
        LocalUtil::redirect('/admin/auth/login');
    }
}
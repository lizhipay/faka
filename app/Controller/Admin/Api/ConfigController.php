<?php
declare (strict_types=1);

namespace app\Controller\Admin\Api;


use App\Controller\AdminApiBaseController;
use App\Interceptor\AdminApiInterceptor;
use App\Utils\StringUtil;
use Core\Utils\Bridge;

/**
 * Class ConfigController
 * @package app\Controller\Admin\Api
 * @Interceptor(AdminApiInterceptor::class)
 */
class ConfigController extends AdminApiBaseController
{
    /**
     * 设置资料
     * @return array
     * @throws \Core\Exception\JSONException
     */
    public function edit(): array
    {
        $file = $_POST['ico'];
        if ($file != '/favicon.ico') {
            @copy(BASE_PATH . $file, BASE_PATH . '/favicon.ico');
            @unlink(BASE_PATH . $file);
        }
        Bridge::setConfig('site', $_POST);
        return $this->json(200, '修改成功');
    }


    /**
     * @return array
     * @throws \Core\Exception\JSONException
     */
    public function editEmail(): array
    {
        Bridge::setConfig('email', $_POST);
        return $this->json(200, '修改成功');
    }

}
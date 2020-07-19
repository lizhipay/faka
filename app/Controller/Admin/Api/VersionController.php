<?php
declare (strict_types=1);

namespace app\Controller\Admin\Api;


use App\Controller\AdminApiBaseController;
use App\Interceptor\AdminApiInterceptor;
use App\Service\VersionServiceInterface;

/**
 * Class VersionController
 * @package app\Controller\Admin\Api
 * @Interceptor(AdminApiInterceptor::class)
 */
class VersionController extends AdminApiBaseController
{

    /**
     * @Inject
     * @var VersionServiceInterface
     */
    public $versionService;


    /**
     * 获取最新版本
     * @return array
     */
    public function getVersion(): array
    {
        $versionInfos = $this->versionService->getVersionInfo();
        $versionInfo = end($versionInfos);
        if ($versionInfo['version']) {
            $versionInfo['localVersion'] = LIZHI_VERSION;
            return $this->json(200, 'success', $versionInfo);
        } else {
            return $this->json(200, 'success', ['version' => LIZHI_VERSION, 'localVersion' => LIZHI_VERSION]);
        }
    }

    /**
     * 更新至最新版本
     * @return array
     */
    public function update(): array
    {
        $this->versionService->update();
        //升级完成
        return $this->json(200, '更新成功');
    }
}
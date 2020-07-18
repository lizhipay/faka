<?php
declare (strict_types=1);

namespace app\Controller\Admin\Api;

use App\Controller\AdminApiBaseController;
use App\Interceptor\AdminApiInterceptor;
use App\Service\UploadServiceInterface;
use Core\Exception\JSONException;


/**
 * Class UploadController
 * @package app\Controller\Admin\Api
 * @Interceptor(AdminApiInterceptor::class)
 */
class UploadController extends AdminApiBaseController
{

    /**
     * @Inject
     * @var UploadServiceInterface
     */
    public $uploadService;

    /**
     * 文件上传
     * @return array
     * @throws JSONException
     */
    public function handle(): array
    {
        $handle = $this->uploadService->handle($_FILES['file'], BASE_PATH . '/assets/static/images', ['jpg', 'png', 'jpeg', 'ico', 'gif', 'ico'], 10240);
        if (!is_array($handle)) {
            throw new JSONException($handle);
        }
        return $this->json(200, '上传成功', ['path' => '/assets/static/images/' . $handle['new_name']]);
    }

}
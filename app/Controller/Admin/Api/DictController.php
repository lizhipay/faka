<?php
declare (strict_types=1);

namespace App\Controller\Admin\Api;

use App\Controller\AdminApiBaseController;
use App\Service\DictServiceInterface;
use App\Interceptor\AdminApiInterceptor;


/**
 * Class DictController
 * @package App\Controller\User\Api
 * @Interceptor(AdminApiInterceptor::class)
 */
class DictController extends AdminApiBaseController
{


    /**
     * @Inject
     * @var DictServiceInterface
     */
    public $dictService;


    /**
     * @return array
     */
    public function get(): array
    {
        $dict = $this->dictService->getDict((string)$_POST['dict'], (string)$_POST['keywords']);
        return $this->json(200, null, (array)$dict);
    }
}
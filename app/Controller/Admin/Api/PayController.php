<?php
declare (strict_types=1);

namespace app\Controller\Admin\Api;

use App\Controller\AdminApiBaseController;
use App\Entity\CreateObjectEntity;
use App\Entity\DeleteBatchEntity;
use App\Entity\QueryTemplateEntity;
use App\Model\Pay;
use App\Quickly\QueryServiceQuickly;
use Core\Exception\JSONException;
use App\Interceptor\AdminApiInterceptor;
use Core\Utils\Bridge;

/**
 * Class PayController
 * @package app\Controller\Admin\Api
 * @Interceptor(AdminApiInterceptor::class)
 */
class PayController extends AdminApiBaseController
{

    use QueryServiceQuickly;

    /**
     * 获取支付方式
     * @return array
     */
    public function data(): array
    {
        $map = $_POST;
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(Pay::class);
        $queryTemplateEntity->setLimit((int)$_POST['limit']);
        $queryTemplateEntity->setPage((int)$_POST['page']);
        $queryTemplateEntity->setPaginate(true);
        $queryTemplateEntity->setWhere($map);
        $data = $this->findTemplateAll($queryTemplateEntity)->toArray();
        $json = $this->json(200, null, $data['data']);
        $json['count'] = $data['total'];
        return $json;
    }


    /**
     * 保存/添加支付方式
     * @return array
     * @throws JSONException
     */
    public function save(): array
    {
        $map = $_POST;
        $createObjectEntity = new CreateObjectEntity();
        $createObjectEntity->setModel(Pay::class);
        $createObjectEntity->setMap($map);
        $createObjectEntity->setCreateDate('create_date');
        $save = $this->createOrUpdateTemplate($createObjectEntity);
        if (!$save) {
            throw new JSONException("本次操作没有任何更改");
        }
        return $this->json(200, '操作成功');
    }


    /**
     * @return array
     * @throws JSONException
     */
    public function del(): array
    {
        $deleteBatchEntity = new DeleteBatchEntity();
        $deleteBatchEntity->setModel(Pay::class);
        $deleteBatchEntity->setList($_POST['list']);
        $count = $this->deleteTemplate($deleteBatchEntity);
        if ($count == 0) {
            throw new JSONException("本次删除没有成功");
        }
        return $this->json(200, '删除成功');
    }

    /**
     * @return array
     */
    public function editConfig(): array
    {
        Bridge::setConfig('pay', $_POST);
        return $this->json(200, '修改成功');
    }

}
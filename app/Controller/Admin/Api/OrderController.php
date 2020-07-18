<?php
declare (strict_types=1);

namespace app\Controller\Admin\Api;


use App\Controller\AdminApiBaseController;
use App\Entity\CreateObjectEntity;
use App\Entity\QueryTemplateEntity;
use App\Interceptor\AdminApiInterceptor;
use App\Model\Order;
use App\Quickly\QueryServiceQuickly;
use Core\Exception\JSONException;

/**
 * Class OrderController
 * @package app\Controller\Admin\Api
 * @Interceptor(AdminApiInterceptor::class)
 */
class OrderController extends AdminApiBaseController
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
        $queryTemplateEntity->setModel(Order::class);
        $queryTemplateEntity->setLimit((int)$_POST['limit']);
        $queryTemplateEntity->setPage((int)$_POST['page']);
        $queryTemplateEntity->setPaginate(true);
        $queryTemplateEntity->setWhere($map);
        $queryTemplateEntity->setWith(['pay']);
        $data = $this->findTemplateAll($queryTemplateEntity)->toArray();
        $json = $this->json(200, null, $data['data']);
        $json['count'] = $data['total'];
        return $json;
    }

    /**
     * @return array
     * @throws JSONException
     */
    public function save(): array
    {
        $map = $_POST;
        $createObjectEntity = new CreateObjectEntity();
        $createObjectEntity->setModel(Order::class);
        $createObjectEntity->setMap($map);
        $createObjectEntity->setCreateDate('create_date');
        $save = $this->createOrUpdateTemplate($createObjectEntity);
        if (!$save) {
            throw new JSONException("本次操作没有任何更改");
        }
        return $this->json(200, '操作成功');
    }

}
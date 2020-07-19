<?php
declare (strict_types=1);

namespace app\Controller\Admin\Api;

use App\Controller\AdminApiBaseController;
use App\Entity\CreateObjectEntity;
use App\Entity\DeleteBatchEntity;
use App\Entity\QueryTemplateEntity;
use App\Interceptor\AdminApiInterceptor;
use App\Model\Commodity;
use App\Quickly\QueryServiceQuickly;
use Core\Exception\JSONException;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CommodityController
 * @package app\Controller\Admin\Api
 * @Interceptor(AdminApiInterceptor::class)
 */
class CommodityController extends AdminApiBaseController
{
    use QueryServiceQuickly;

    /**
     * @return array
     */
    public function data(): array
    {
        $map = $_POST;
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(Commodity::class);
        $queryTemplateEntity->setLimit((int)$_POST['limit']);
        $queryTemplateEntity->setPage((int)$_POST['page']);
        $queryTemplateEntity->setPaginate(true);
        $queryTemplateEntity->setWhere($map);
        $queryTemplateEntity->setOrder('sort', 'asc');
        $queryTemplateEntity->setWith(['category']);
        $queryTemplateEntity->setWithCount(['card as card_count' => function (Builder $builder) {
            $builder->where("status", 0);
        }]);
        $queryTemplateEntity->setWithCount(['card as card_success_count' => function (Builder $builder) {
            $builder->where("status", 1);
        }]);
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
        $createObjectEntity->setModel(Commodity::class);
        $createObjectEntity->setMap($map);
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
        $deleteBatchEntity->setModel(Commodity::class);
        $deleteBatchEntity->setList($_POST['list']);
        $count = $this->deleteTemplate($deleteBatchEntity);
        if ($count == 0) {
            throw new JSONException("本次删除没有成功");
        }
        return $this->json(200, '删除成功');
    }
}
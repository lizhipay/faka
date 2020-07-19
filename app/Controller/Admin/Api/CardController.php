<?php
declare (strict_types=1);

namespace app\Controller\Admin\Api;


use App\Controller\AdminApiBaseController;
use App\Entity\DeleteBatchEntity;
use App\Entity\QueryTemplateEntity;
use App\Interceptor\AdminApiInterceptor;
use App\Model\Card;
use App\Quickly\QueryServiceQuickly;
use App\Utils\DateUtil;
use Core\Exception\JSONException;

/**
 * Class CardController
 * @package app\Controller\Admin\Api
 * @Interceptor(AdminApiInterceptor::class)
 */
class CardController extends AdminApiBaseController
{
    use QueryServiceQuickly;

    /**
     * @return array
     */
    public function data(): array
    {
        $map = $_POST;
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(Card::class);
        $queryTemplateEntity->setLimit((int)$_POST['limit']);
        $queryTemplateEntity->setPage((int)$_POST['page']);
        $queryTemplateEntity->setPaginate(true);
        $queryTemplateEntity->setWhere($map);
        $queryTemplateEntity->setWith(['commodity']);
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
        $commodityId = (int)$_POST['commodity_id'];
        if ($commodityId == 0) {
            throw new JSONException('欧尼酱，请选择商品~');
        }
        $cards = trim(trim((string)$_POST['cards']), PHP_EOL);
        //进行批量插入
        if ($cards == '') {
            throw new JSONException('欧尼酱，请至少添加1条卡密信息哦，否则是无法成功的~');
        }
        $cards = explode(PHP_EOL, $cards);
        $count = count($cards);
        $success = 0;
        $error = 0;
        $date = DateUtil::current();
        foreach ($cards as $card) {
            $cardObj = new Card();
            $cardObj->commodity_id = $commodityId;
            $cardObj->card = trim($card);
            $cardObj->create_date = $date;
            $cardObj->status = 0;
            try {
                $cardObj->save();
                $success++;
            } catch (\Exception $e) {
                $error++;
            }
        }
        return $this->json(200, "共计导入:{$count}张卡密，成功:{$success}张，失败：{$error}张");
    }


    /**
     * @return array
     * @throws JSONException
     */
    public function del(): array
    {
        $deleteBatchEntity = new DeleteBatchEntity();
        $deleteBatchEntity->setModel(Card::class);
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
    public function lock(): array
    {
        $list = (array)$_POST['list'];
        Card::query()->whereIn('id', $list)->whereRaw("status!=1")->update(['status' => 2]);
        return $this->json(200, '锁定成功');
    }

    /**
     * @return array
     */
    public function unlock(): array
    {
        $list = (array)$_POST['list'];
        Card::query()->whereIn('id', $list)->whereRaw("status!=1")->update(['status' => 0]);
        return $this->json(200, '解锁成功');
    }


    /**
     * 导出
     * @return string
     */
    public function export(): string
    {
        $map = $_GET;
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(Card::class);
        $queryTemplateEntity->setWhere($map);
        $data = $this->findTemplateAll($queryTemplateEntity);
        $card = '';
        foreach ($data as $d) {
            $card .= $d->card . PHP_EOL;
        }
        header('Content-Type:application/octet-stream');
        header('Content-Transfer-Encoding:binary');
        header('Content-Disposition:attachment; filename=卡密导出-' . DateUtil::current() . '.txt');
        return $card;
    }
}
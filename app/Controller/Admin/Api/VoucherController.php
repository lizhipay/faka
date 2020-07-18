<?php
declare (strict_types=1);

namespace app\Controller\Admin\Api;


use App\Controller\AdminApiBaseController;
use App\Entity\DeleteBatchEntity;
use App\Entity\QueryTemplateEntity;
use App\Interceptor\AdminApiInterceptor;
use App\Model\Voucher;
use App\Quickly\QueryServiceQuickly;
use App\Utils\DateUtil;
use App\Utils\StringUtil;
use Core\Exception\JSONException;

/**
 * Class VoucherController
 * @package app\Controller\Admin\Api
 * @Interceptor(AdminApiInterceptor::class)
 */
class VoucherController extends AdminApiBaseController
{
    use QueryServiceQuickly;

    /**
     * @return array
     */
    public function data(): array
    {
        $map = $_POST;
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(Voucher::class);
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
        $expireDate = (string)$_POST['expire_date'];
        $money = (float)$_POST['money'];
        $num = (int)$_POST['num'];

        if ($commodityId == 0) {
            throw new JSONException('欧尼酱，请选择商品~');
        }

        if ($money <= 0) {
            throw new JSONException("优惠卷的金额太离谱啦欧尼酱~！");
        }

        if ($expireDate != '' && strtotime($expireDate) < time()) {
            throw new JSONException("优惠卷的到期时间不能是过去的时间哦，欧尼酱~");
        }

        if ($num <= 0) {
            throw new JSONException("最少也要生成1张优惠卷！");
        }

        $date = DateUtil::current();
        $success = 0;
        $error = 0;

        for ($i = 0; $i < $num; $i++) {
            $voucher = new Voucher();
            $voucher->voucher = StringUtil::generateRandStr(8);
            $voucher->commodity_id = $commodityId;
            $voucher->create_date = $date;
            if ($expireDate != '') {
                $voucher->expire_date = $expireDate;
            }
            $voucher->money = $money;
            $voucher->status = 0;
            try {
                $voucher->save();
                $success++;
            } catch (\Exception $e) {
                $error++;
            }
        }

        return $this->json(200, "生成完毕，成功:{$success}张，失败：{$error}张");
    }


    /**
     * @return array
     * @throws JSONException
     */
    public function del(): array
    {
        $deleteBatchEntity = new DeleteBatchEntity();
        $deleteBatchEntity->setModel(Voucher::class);
        $deleteBatchEntity->setList($_POST['list']);
        $count = $this->deleteTemplate($deleteBatchEntity);
        if ($count == 0) {
            throw new JSONException("本次删除没有成功");
        }
        return $this->json(200, '删除成功');
    }

    /**
     * 导出
     * @return string
     */
    public function export(): string
    {
        $map = $_GET;
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(Voucher::class);
        $queryTemplateEntity->setWhere($map);
        $data = $this->findTemplateAll($queryTemplateEntity);
        $card = '';
        foreach ($data as $d) {
            $card .= $d->voucher . PHP_EOL;
        }
        header('Content-Type:application/octet-stream');
        header('Content-Transfer-Encoding:binary');
        header('Content-Disposition:attachment; filename=优惠卷导出-' . DateUtil::current() . '.txt');
        return $card;
    }
}
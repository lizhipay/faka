<?php
declare (strict_types=1);

namespace App\Controller;


use App\Model\Category;
use App\Model\Order;
use App\Model\Pay;
use App\Utils\DateUtil;
use App\Utils\LocalUtil;
use Core\Exception\RuntimeException;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends IndexBaseController
{
    /**
     * @throws RuntimeException
     */
    public function index(): string
    {
        //判断是否安装
        if (!file_exists(BASE_PATH . '/core/Install/lock')) {
            LocalUtil::redirect('/install/setup');
        }
        //获取商品分类
        $category = Category::query()->withCount(['commodity as commodity_count' => function (Builder $builder) {
            $builder->where("status", 1);
        }])->where("status", 1)->orderBy("sort", "asc")->get()->toArray();
        //获取支付方式
        $pay = Pay::query()->where("status", 1)->get()->toArray();
        //获取统计数据
        //今日盈利
        $statistics['todaySuccessAmount'] = Order::query()->where("status", 1)->whereBetween('create_date', [DateUtil::calcDay(), DateUtil::calcDay(1)])->sum("amount");
        //今日订单
        $statistics['todaySuccessCount'] = Order::query()->where("status", 1)->whereBetween('create_date', [DateUtil::calcDay(), DateUtil::calcDay(1)])->count();
        //总盈利
        $statistics['allSuccessAmount'] = Order::query()->where("status", 1)->sum("amount");
        //总订单
        $statistics['allSuccessCount'] = Order::query()->where("status", 1)->count();

        return $this->render('首页', 'index.html', ['category' => $category, 'pay' => $pay, 'statistics' => $statistics]);
    }


    /**
     * 查询订单页面
     * @return string
     * @throws RuntimeException
     */
    public function query(): string
    {
        $tradeNo = (string)$_GET['tradeNo'];
        return $this->render('订单查询', 'query.html', ['tradeNo' => $tradeNo]);
    }
}
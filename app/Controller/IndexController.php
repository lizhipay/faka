<?php
declare (strict_types=1);

namespace App\Controller;


use App\Model\Category;
use App\Model\Pay;
use App\Utils\AddressUtil;
use App\Utils\LocalUtil;
use Core\Utils\View;
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
        return $this->render('首页', 'index.html', ['category' => $category, 'pay' => $pay]);
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
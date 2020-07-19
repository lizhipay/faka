<?php
declare (strict_types=1);

namespace app\Controller\Admin;


use App\Controller\AdminBaseController;
use App\Interceptor\AdminInterceptor;
use App\Model\Card;
use App\Model\Order;
use App\Utils\DateUtil;
use Core\Exception\RuntimeException;
use Core\Utils\Bridge;

/**
 * Class IndexController
 * @package app\Controller\Admin
 * @Interceptor(AdminInterceptor::class)
 */
class IndexController extends AdminBaseController
{

    /**
     * @return string
     * @throws RuntimeException
     */
    public function home()
    {
        $data = [];
        //今日盈利
        $data['todaySuccessAmount'] = Order::query()->where("status", 1)->whereBetween('create_date', [DateUtil::calcDay(), DateUtil::calcDay(1)])->sum("amount");
        //今日售卡
        $data['todaySuccessCard'] = Card::query()->where("status", 1)->whereBetween('buy_date', [DateUtil::calcDay(), DateUtil::calcDay(1)])->count();
        //昨日盈利
        $data['yesterdaySuccessAmount'] = Order::query()->where("status", 1)->whereBetween('create_date', [DateUtil::calcDay(-1), DateUtil::calcDay()])->sum("amount");
        //昨日售卡
        $data['yesterdaySuccessCard'] = Card::query()->where("status", 1)->whereBetween('buy_date', [DateUtil::calcDay(-1), DateUtil::calcDay()])->count();
        //总盈利
        $data['allSuccessAmount'] = Order::query()->where("status", 1)->sum("amount");
        //总售卡
        $data['allSuccessCard'] = Card::query()->where("status", 1)->count();

        return $this->render('控制台', 'home.html', ['data' => $data]);
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function pay()
    {
        return $this->render('支付方式', 'pay.html');
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function personal()
    {
        return $this->render('个人资料', 'personal.html');
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function order()
    {
        $tradeNo = $_GET['tradeNo'];
        return $this->render('订单记录', 'order.html', ['tradeNo' => $tradeNo]);
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function category()
    {
        return $this->render('商品分类', 'category.html');
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function commodity()
    {
        return $this->render('商品管理', 'commodity.html');
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function voucher()
    {
        return $this->render('优惠卷', 'voucher.html');
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function card()
    {
        return $this->render('卡密管理', 'card.html');
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function config()
    {
        return $this->render('网站配置', 'config.html', ['config' => Bridge::getConfig('site')]);
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function email()
    {
        return $this->render('邮件配置', 'email.html', ['email' => Bridge::getConfig('email')]);
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    public function payConfig()
    {
        return $this->render('支付配置', 'payConfig.html', ['pay' => Bridge::getConfig('pay')]);
    }
}
<?php
declare (strict_types=1);

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $trade_no
 * @property float $amount
 * @property int $pay_id
 * @property int $commodity_id
 * @property string $create_date
 * @property string $create_ip
 * @property string $create_device
 * @property string $pay_date
 * @property int $status
 * @property string $commodity
 * @property string $pass
 * @property string $contact
 * @property int $voucher_id
 * @property int $num
 * @property int $send
 */
class Order extends Model
{
    /**
     * @var string
     */
    protected $table = 'order';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = ['id' => 'integer', 'commodity_id' => 'integer', 'send' => 'integer', 'num' => 'integer', 'amount' => 'float', 'pay_id' => 'integer', 'status' => 'integer', 'voucher_id' => 'integer'];

    //获取支付方式
    public function pay()
    {
        return $this->hasOne(Pay::class, 'id', 'pay_id');
    }

    //获取优惠卷
    public function voucher()
    {
        return $this->hasOne(Voucher::class, 'id', 'voucher_id');
    }

    //获取商品
    public function shop()
    {
        return $this->hasOne(Commodity::class, 'id', 'commodity_id');
    }
}
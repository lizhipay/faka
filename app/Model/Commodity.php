<?php
declare (strict_types=1);

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $desc
 * @property float $price
 * @property int $wholesale_status
 * @property string $wholesale
 * @property int $contact
 * @property string $contact_tips
 * @property int $status
 * @property int $sort
 * @property int $voucher_status
 */
class Commodity extends Model
{
    /**
     * @var string
     */
    protected $table = 'commodity';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = ['id' => 'integer', 'category_id' => 'integer', 'sort' => 'integer', 'price' => 'float', 'wholesale_status' => 'integer', 'contact' => 'integer', 'status' => 'integer', 'voucher_status' => 'integer'];

    //商品分类
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    //获取卡密
    public function card()
    {
        return $this->hasMany(Card::class, 'commodity_id', 'id');
    }
}
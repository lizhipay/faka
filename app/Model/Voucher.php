<?php
declare (strict_types=1);

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $commodity_id
 * @property string $voucher
 * @property string $create_date
 * @property string $use_date
 * @property string $expire_date
 * @property float $money
 * @property int $status
 * @property string $contact
 */
class Voucher extends Model
{
    /**
     * @var string
     */
    protected $table = 'voucher';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = ['id' => 'integer', 'commodity_id' => 'integer', 'money' => 'float', 'status' => 'integer'];


    //商品
    public function commodity()
    {
        return $this->hasOne(Commodity::class, 'id', 'commodity_id');
    }

}
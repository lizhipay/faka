<?php
declare (strict_types=1);

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $commodity_id
 * @property string $card
 * @property string $create_date
 * @property string $buy_date
 * @property string $contact
 * @property int $status
 */
class Card extends Model
{
    /**
     * @var string
     */
    protected $table = 'card';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = ['id' => 'integer', 'commodity_id' => 'integer', 'status' => 'integer'];

    //获取商品
    public function commodity()
    {
        return $this->hasOne(Commodity::class, 'id', 'commodity_id');
    }
}
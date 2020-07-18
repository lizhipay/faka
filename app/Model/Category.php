<?php
declare (strict_types=1);

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $status
 * @property int $sort
 */
class Category extends Model
{
    /**
     * @var string
     */
    protected $table = 'category';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = ['id' => 'integer', 'status' => 'integer', 'sort' => 'integer'];

    //获取分类下的商品
    public function commodity()
    {
        return $this->hasMany(Commodity::class, 'category_id', 'id');
    }
}
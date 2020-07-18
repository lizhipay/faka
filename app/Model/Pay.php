<?php
declare (strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $face
 * @property string $code
 * @property int $status
 */
class Pay extends Model
{
    /**
     * @var string
     */
    protected $table = 'pay';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = ['id' => 'integer', 'status' => 'integer'];
}
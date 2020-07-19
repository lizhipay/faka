<?php
declare (strict_types=1);

namespace app\Controller\Index\Api;

use App\Controller\IndexBaseController;
use App\Model\Commodity;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ShopController
 * @package app\Controller\Index\Api
 */
class ShopController extends IndexBaseController
{
    /**
     * 获取商品列表
     * @param int $categoryId
     * @return array
     */
    public function getCommodity($categoryId): array
    {
        $data = Commodity::query()->withCount(['card as card_count' => function (Builder $relation) {
            $relation->where("status", 0);
        }])->where("category_id", $categoryId)->where("status", 1)->orderBy("sort", "asc")->get()->toArray();

        return $this->json(200, 'success', $data);
    }
}
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


/*
        if ($data['wholesale_status'] == 1) {
            $list = [];
            $x = '';
            $wholesales = explode(PHP_EOL, trim(trim((string)$data['wholesale']), PHP_EOL));
            foreach ($wholesales as $item) {
                $s = explode('-', $item);
                if (count($s) == 2) {
                    $list[$s[0]] = $s[1];
                }
            }
            ksort($list);
            foreach ($list as $k => $v) {
                $x .= '<div>购买' . $k . '张，单价自动调整为：<b>' . number_format($v, 2, '.', '') . '</b>元</div>';
            }

            $data['wholesale'] = $x;
        }*/

        return $this->json(200, 'success', $data);
    }
}
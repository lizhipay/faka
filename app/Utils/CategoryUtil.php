<?php


namespace App\Utils;


class CategoryUtil
{
    /**
     * 数组无限极分类
     * @param array $array
     * @param string $primary_key
     * @param string $parent_key
     * @param string $childrenName
     * @return array
     */
    public static function generateTree(array $array, string $primary_key = 'id', string $parent_key = 'pid', string $childrenName = 'children'): array
    {
        $items = array();
        foreach ($array as $row) {
            $row = (array)$row;
            $items[$row[$primary_key]] = $row;
        }
        $tree = array();
        foreach ($items as $k => $item) {
            if (isset($items[$item[$parent_key]])) {
                $items[$item[$parent_key]][$childrenName][] = &$items[$k];
            } else {
                $tree[] = &$items[$k];
            }
        }
        return $tree;
    }
}
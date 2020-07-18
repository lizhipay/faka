<?php


namespace App\Service;

/**
 * Interface DictServiceInterface
 * @package App\Service
 */
interface DictServiceInterface
{
    /**
     * 获取字典列表
     * @param string $dictName
     * @param string $keywords
     * @param string $where
     * @return mixed
     */
    public function getDict(string $dictName, string $keywords = '', string $where = '');
}
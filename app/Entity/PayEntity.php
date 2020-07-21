<?php
declare (strict_types=1);

namespace App\Entity;

/**
 * 支付实体类
 * Class PayEntity
 * @package app\Entity
 */
class PayEntity
{
    /**
     * 支付呈现方式
     * @var integer
     */
    private $type;


    /**
     * 支付地址
     * @var string
     */
    private $url;

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
<?php
declare (strict_types=1);

namespace App\Service;

/**
 * Interface OrderServiceInterface
 * @package App\Service
 */
interface OrderServiceInterface
{
    /**
     * 下单
     * @param string $contact
     * @param int $num
     * @param string $pass
     * @param int $payId
     * @param int $device
     * @param string $voucher
     * @param int $commodityId
     * @param string $ip
     * @param array $post
     * @return mixed
     */
    public function trade(string $contact, int $num, string $pass, int $payId, int $device, string $voucher, int $commodityId, string $ip, array $post): array;


    /**
     * @param array $map
     * @return mixed
     */
    public function callback(array $map): string;
}
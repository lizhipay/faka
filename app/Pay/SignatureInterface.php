<?php
declare (strict_types=1);

namespace App\Pay;


interface SignatureInterface
{
    /**
     * @param array $post
     * @param array $config
     * @return bool
     */
    public function verification(array $post, array $config): bool;
}
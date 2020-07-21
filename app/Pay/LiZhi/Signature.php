<?php
declare (strict_types=1);

namespace App\Pay\LiZhi;


use App\Pay\LiZhi\Utils\StringUtil;
use App\Pay\SignatureInterface;

class Signature implements SignatureInterface
{

    /**
     * @inheritDoc
     */
    public function verification(array $post, array $config): bool
    {
        $generateSignature = StringUtil::generateSignature($post, $config['key']);
        if ($post['sign'] != $generateSignature) {
            return false;
        }
        return true;
    }
}
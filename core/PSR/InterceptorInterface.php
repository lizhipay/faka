<?php
declare (strict_types=1);

namespace Core\PSR;

/**
 * Interface InterceptorInterface
 * @package Core\PSR
 */
interface InterceptorInterface
{
    /**
     * @return void
     */
    public function handle(): void;
}
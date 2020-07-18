<?php
declare (strict_types=1);

namespace Core\PSR;

use Throwable;

/**
 * Interface AppExceptionInterface
 * @package core\PSR
 */
interface AppExceptionInterface
{
    /**
     * @param Throwable $throwable
     */
    public function handle(Throwable $throwable): void;
}
<?php
declare (strict_types=1);

namespace App\Exception;


use App\Utils\LocalUtil;
use Core\Exception\JSONException;
use Core\Exception\ViewException;
use Core\PSR\AppExceptionInterface;
use Throwable;

class AppException implements AppExceptionInterface
{

    /**
     * @inheritDoc
     * @throws \SmartyException
     */
    public function handle(Throwable $throwable): void
    {
        if ($throwable instanceof JSONException) {
            echo json_encode(['code' => $throwable->getCode(), 'msg' => $throwable->getMessage()], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else if ($throwable instanceof ViewException) {
            echo LocalUtil::error($throwable->getMessage(), '/admin/auth/login');
        } else {
            dd($throwable);
        }
    }
}
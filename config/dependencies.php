<?php
declare(strict_types=1);


return [
    \App\Service\UploadServiceInterface::class => \App\Service\impl\UploadService::class,
    \App\Service\DictServiceInterface::class => \App\Service\impl\DictService::class,
    \App\Service\OrderServiceInterface::class => \App\Service\impl\OrderService::class,
    \App\Service\VersionServiceInterface::class => \App\Service\impl\VersionService::class,
    \App\Service\PayServiceInterface::class => \App\Service\impl\PayService::class
];

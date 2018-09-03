<?php
return [
    'definitions' => [
        \app\repositories\TransferRepoInteface::class => \app\repositories\TransferRepo::class,
        \app\repositories\UserRepoInteface::class => \app\repositories\UserRepo::class,
        \app\services\ProcessTransfersServiceInterface::class => \app\services\ProcessTransfersService::class,
        \app\services\UserTransferBalanceServiceInterface::class => \app\services\UserTransferBalanceService::class,
    ],
    'singletons' => [
    ]
];
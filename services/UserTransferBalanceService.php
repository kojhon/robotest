<?php
namespace app\services;

use app\repositories\TransferRepoInteface;
use app\repositories\UserRepoInteface;
use yii\db\Connection;

class UserTransferBalanceService implements UserTransferBalanceServiceInterface
{
    private $userRepo;

    private $transfersRepo;

    public function __construct(
        UserRepoInteface $userRepoInteface,
        TransferRepoInteface $transferRepoInteface
    ) {
        $this->userRepo = $userRepoInteface;
        $this->transfersRepo = $transferRepoInteface;
    }

    public function getUserTransferBalance($userId)
    {
        $user = $this->userRepo->findUserById($userId);
        return $user->balance - $this->transfersRepo->findIncompleteOutcomingTransfersSum($userId);
    }

    public function getDoubleUserTransferBalance($userId)
    {
        return bcdiv($this->getUserTransferBalance($userId), 100, 2);
    }

}
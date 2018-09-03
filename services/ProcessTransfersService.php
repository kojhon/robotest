<?php
namespace app\services;

use app\exceptions\UserNegativeBalanceException;
use app\models\User;
use app\repositories\TransferRepoInteface;
use app\repositories\UserRepoInteface;
use yii\base\Exception;
use yii\db\Connection;

class ProcessTransfersService implements ProcessTransfersServiceInterface
{
    private $transfersRepo;
    private $userRepo;

    public function __construct(
        TransferRepoInteface $transferRepoInteface,
        UserRepoInteface $userRepoInteface
    ) {
        $this->transfersRepo = $transferRepoInteface;
        $this->userRepo = $userRepoInteface;
    }

    public function proccessTransfers(\DateTime $currentTime)
    {
        $transfers = $this->transfersRepo->findIncompleteTransfersWithProcessAtLessThanDate($currentTime);
        if (empty($transfers)) return;
        /** @var User[] $users */
        $users = [];
        foreach ($transfers as $transfer) {
            if (empty($users[$transfer->from_user])) {
                $users[$transfer->from_user] = $this->userRepo->findUserById($transfer->from_user);
            }

            if (empty($users[$transfer->to_user])) {
                $users[$transfer->to_user] = $this->userRepo->findUserById($transfer->to_user);
            }

            $users[$transfer->from_user]->balance = $users[$transfer->from_user]->balance - $transfer->sum;
            $users[$transfer->to_user]->balance = $users[$transfer->to_user]->balance + $transfer->sum;
        }

        foreach ($users as $user) {
            if ($user->balance < 0) {
                throw new UserNegativeBalanceException("After process transfers user with id {$user->getId()} have negative balance");
            }
        }

        $db = (reset($users))->getDb();
        $transaction = $db->beginTransaction();
        try {
            foreach ($transfers as $transfer) {
                $transfer->is_processed = true;
                if (!$transfer->save()) throw new Exception($transfer->getErrorSummary(true));
            }

            foreach ($users as $user) {
                if (!$user->save()) throw new Exception($transfer->getErrorSummary(true));
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }


}
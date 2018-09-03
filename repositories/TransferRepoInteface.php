<?php
namespace app\repositories;

use app\models\MoneyTransfer;

interface TransferRepoInteface
{
    /**
     * @param $userId
     * @return integer
     */
    public function findIncompleteOutcomingTransfersSum($userId);

    /**
     * @param $date \DateTime
     * @return MoneyTransfer[]
     */
    public function findIncompleteTransfersWithProcessAtLessThanDate($date);

    /**
     * @return array
     */
    public function findUsersWithLastTransactions();
}
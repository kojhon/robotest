<?php
namespace app\repositories;

use app\models\MoneyTransfer;

class TransferRepo implements TransferRepoInteface
{
    /**
     * @inheritdoc
     */
    public function findIncompleteOutcomingTransfersSum($userId)
    {
        return MoneyTransfer::find()->where([
            'from_user' => $userId,
            'is_processed' => false,
        ])->sum('sum');
    }

    /**
     * @inheritdoc
     */
    public function findIncompleteTransfersWithProcessAtLessThanDate($date)
    {
        return MoneyTransfer::find()->where(
                ['is_processed' => false]
            )->andWhere('process_after <= :time', [':time' => $date->format('c')])
            ->all();
    }


}
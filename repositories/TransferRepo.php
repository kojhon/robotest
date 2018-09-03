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

    /**
     * @inheritdoc
     */
    public function findUsersWithLastTransactions()
    {
        return \Yii::$app->db->createCommand(
            "WITH last_created_transfers AS (".
                    " SELECT MAX(id) AS id".
                    " FROM money_transfers".
                    " GROUP BY from_user".
                " )".
                " SELECT u.username, t.sum, t.process_after".
                " FROM users AS u".
                    " LEFT JOIN money_transfers AS t ON t.from_user = u.id".
                " WHERE t.id IN (SELECT id FROM last_created_transfers) OR t.id IS NULL"
        )->queryAll();
    }


}
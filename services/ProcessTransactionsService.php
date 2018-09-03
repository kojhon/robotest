<?php
namespace app\services;

use yii\db\Connection;

class ProcessTransactionsService implements ProcessTransactionsServiceInterface
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function proccessTransactions(\DateTime $currentTime)
    {
    }
}
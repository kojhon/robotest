<?php
namespace app\services;

interface ProcessTransactionsServiceInterface
{
    public function proccessTransactions(\DateTime $currentTime);
}
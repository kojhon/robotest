<?php
namespace app\services;

interface UserTransferBalanceServiceInterface
{
    /**
     * @param integer $userId
     * @return integer
     */
    public function getUserTransferBalance($userId);

    /**
     * @param integer $userId
     * @return float
     */
    public function getDoubleUserTransferBalance($userId);
}
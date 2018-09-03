<?php
namespace app\services;

interface ProcessTransfersServiceInterface
{
    public function proccessTransfers(\DateTime $currentTime);
}
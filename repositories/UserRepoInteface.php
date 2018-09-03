<?php
namespace app\repositories;

use app\models\User;

interface UserRepoInteface
{
    /**
     * @param $userId
     * @return User|null
     */
    public function findUserById($userId);
}
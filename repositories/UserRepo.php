<?php
namespace app\repositories;

use app\models\User;

class UserRepo implements UserRepoInteface
{
    /**
     * @inheritdoc
     */
    public function findUserById($userId) {
        return User::findIdentity($userId);
    }
}
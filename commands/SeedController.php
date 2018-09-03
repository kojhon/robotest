<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\MoneyTransfer;
use app\models\User;
use app\services\ProcessTransfersServiceInterface;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SeedController extends Controller
{
    public function actionIndex()
    {
        $firstUser = new User();
        $firstUser->username = 'test1';
        $firstUser->password = 'qwerty1';
        $firstUser->balance = 100000;
        $firstUser->save();

        $secondUser = new User();
        $secondUser->username = 'test2';
        $secondUser->password = 'qwerty2';
        $secondUser->balance = 100000;
        $secondUser->save();

        $thirdUser = new User();
        $thirdUser->username = 'test3';
        $thirdUser->password = 'qwerty3';
        $thirdUser->balance = 100000;
        $thirdUser->save();

        \Yii::$app->db->createCommand()->batchInsert(
            MoneyTransfer::tableName(),
            [
                'from_user',
                'to_user',
                'sum',
                'is_processed',
                'process_after'
            ],
            [
                [
                    $firstUser->id,
                    $secondUser->id,
                    20000,
                    false,
                    date('c', strtotime('-1 hour')),
                ],
                [
                    $firstUser->id,
                    $thirdUser->id,
                    40000,
                    false,
                    date('c', strtotime('-1 hour')),
                ],
                [
                    $firstUser->id,
                    $thirdUser->id,
                    10000,
                    false,
                    date('c', strtotime('-1 hour')),
                ],
                [
                    $firstUser->id,
                    $thirdUser->id,
                    10000,
                    true,
                    date('c', strtotime('-1 hour')),
                ],
                [
                    $firstUser->id,
                    $secondUser->id,
                    10000,
                    false,
                    date('c', strtotime('+1 day')),
                ],
            ]
        )->execute();

        return ExitCode::OK;
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%money_transfers}}".
 *
 * @property int $id
 * @property int $from_user
 * @property int $to_user
 * @property string $process_after
 * @property bool $is_processed
 * @property integer $sum
 * @property float $floatSum
 *
 * @property User $toUser
 * @property User $fromUser
 */
class MoneyTransfer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%money_transfers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from_user', 'to_user', 'process_after'], 'required'],
            [['from_user', 'to_user'], 'default', 'value' => null],
            [['from_user', 'to_user'], 'integer'],
            [['process_after'], 'safe'],
            [['is_processed'], 'boolean'],
            [['to_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['to_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'from_user' => Yii::t('app', 'From User'),
            'to_user' => Yii::t('app', 'To User'),
            'process_after' => Yii::t('app', 'Process After'),
            'is_processed' => Yii::t('app', 'Is Processed'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::class, ['id' => 'to_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(User::class, ['id' => 'from_user']);
    }

    public function getFloatSum()
    {
        return bcdiv($this->sum, 100, 2);
    }
}

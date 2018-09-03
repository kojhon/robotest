<?php

namespace app\forms;

use app\models\User;
use app\services\UserTransferBalanceServiceInterface;
use Yii;
use yii\base\Model;
use yii\web\BadRequestHttpException;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class MoneyTransferForm extends Model
{
    public $to;
    public $processAfter;
    public $sum;

    /** @var UserTransferBalanceServiceInterface */
    private $userTransferService;


    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->userTransferService = Yii::$container->get(UserTransferBalanceServiceInterface::class);
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['to', 'processAfter', 'sum'], 'required'],
            // password is validated by validatePassword()
            ['sum', 'validateSum'],
            ['processAfter', 'validateProcessAfter'],
            ['sum', 'double', 'min' => 0, 'max' => $this->getBalance()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'to' => 'Your money recipient user',
            'processAfter' => 'Date and time, when transfer will be executed',
            'sum' => 'Transfer sum',
        ];
    }

    private function getBalance()
    {
        /** @var User $user */
        $user = Yii::$app->user->getIdentity();
        if (empty($user)) {
            throw  new BadRequestHttpException('Only authorised users can make money transfers');
        }
        return $this->userTransferService->getDoubleUserTransferBalance($user->getId());
    }


    public function validateSum($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $balance = $this->getBalance();

            if ($this->sum == 0) {
                $this->addError($attribute, 'You can not make transfer with zero sum.');
            }

            if ($balance - $this->sum < 0) {
                $this->addError($attribute, 'You can not make transfer with sum, bigger than ' . $balance . '.');
            }
        }
    }
    public function validateProcessAfter($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $processAfter = new \DateTime($this->processAfter);
            if ($processAfter->getTimestamp() - time() <= 0) {
                $this->addError($attribute, 'You can not select process time less, than current time');
            }
        }
    }
}

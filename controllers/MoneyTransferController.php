<?php

namespace app\controllers;

use app\forms\MoneyTransferForm;
use app\models\User;
use Yii;
use app\models\MoneyTransfer;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MoneyTransferController implements the CRUD actions for MoneyTransfer model.
 */
class MoneyTransferController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MoneyTransfer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $currentUserId = Yii::$app->user->getId();
        $dataProvider = new ActiveDataProvider([
            'query' => MoneyTransfer::find()->where(['from_user' => $currentUserId])->orWhere(['to_user' => $currentUserId]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MoneyTransfer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MoneyTransfer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new MoneyTransferForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $transfer = new MoneyTransfer();
            $transfer->from_user = Yii::$app->user->getId();
            $transfer->to_user = User::findOne(['username' => $form->to])->getId();
            if ($transfer->to_user == $transfer->from_user) throw new BadRequestHttpException('User can not make transfer to himself');
            $transfer->sum = bcmul($form->sum, 100, 0);
            $transfer->process_after = $form->processAfter;
            if ($transfer->save()) {
                return $this->redirect(['view', 'id' => $transfer->id]);
            }
        }

        $currentUserId = Yii::$app->user->getId();
        $recipientList = User::find()->select(['username as value', 'username as label'])->where('id <> :id', [':id' => $currentUserId])->asArray()->all();

        return $this->render('create', [
            'model' => $form,
            'recipientList' => $recipientList
        ]);
    }

    /**
     * Finds the MoneyTransfer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MoneyTransfer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MoneyTransfer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

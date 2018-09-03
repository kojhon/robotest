<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\forms\MoneyTransferForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $recipientList array */

$this->title = 'Create Money Transfer';
$this->params['breadcrumbs'][] = ['label' => 'Money Transfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-transfer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="money-transfer-form">

        <?php $form = \yii\widgets\ActiveForm::begin(); ?>

        <?= $form->field($model, 'to')->widget(\yii\jui\AutoComplete::class, [
            'clientOptions' => [
                'source' => $recipientList,
            ],
        ]) ?>

        <?= $form->field($model, 'processAfter')->widget(\dosamigos\datetimepicker\DateTimePicker::class, [
            'language' => 'en',
            'inline' => false,
            'clientOptions' => [
                'startView' => 1,
                'minView' => 1,
                'maxView' => 4,
                'autoclose' => true,
                'format' => 'yyyy-mm-dd hh:00',
                'todayBtn' => true
            ]
        ]) ?>

        <?= $form->field($model, 'sum')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php \yii\widgets\ActiveForm::end(); ?>

    </div>


</div>

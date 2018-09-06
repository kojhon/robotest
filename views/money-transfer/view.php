<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MoneyTransfer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Money Transfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-transfer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'from_user',
            'to_user',
            'process_after',
            'sum',
            'is_processed:boolean',
        ],
    ]) ?>

</div>

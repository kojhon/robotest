<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Money Transfers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-transfer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Money Transfer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'fromUser.username',
            'toUser.username',
            'process_after',
            'floatSum',
            'is_processed:boolean',
        ],
    ]); ?>
</div>

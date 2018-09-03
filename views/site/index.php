<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome to best money transfer site!</h1>
    </div>

    <div class="body-content">

        <div class="row">
                <h2>List of all users with last transfers:</h2>
                <?= \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'username',
                    'sum',
                    'process_after'
                ],
            ]); ?>
        </div>

    </div>
</div>

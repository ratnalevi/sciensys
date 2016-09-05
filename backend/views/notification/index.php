<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Notification', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'from_user',
            'to_user',
            'message',
            'document_id',
            // 'is_read',
            // 'created_at',
            // 'read_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

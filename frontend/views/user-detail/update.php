<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserDetail */

$this->title = 'Update User Details: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Details', 'url' => ['view-me']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-details-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

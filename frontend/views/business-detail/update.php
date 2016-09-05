<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BusinessDetail */

$this->title = 'Update Business Detail: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Business Details', 'url' => ['view-me']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="business-detail-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

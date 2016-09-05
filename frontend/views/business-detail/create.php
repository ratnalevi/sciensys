<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BusinessDetail */

$this->title = 'Create Business Detail';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="business-detail-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

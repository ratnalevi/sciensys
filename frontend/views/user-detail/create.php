<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UserDetail */

$this->title = 'Create User Details';
$this->params['breadcrumbs'][] = ['label' => 'User Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-details-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Notification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'from_user')->textInput() ?>

    <?= $form->field($model, 'to_user')->textInput() ?>

    <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'document_id')->textInput() ?>

    <?= $form->field($model, 'is_read')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'read_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

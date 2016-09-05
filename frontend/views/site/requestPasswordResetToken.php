<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-box">
    <div class="login-logo">
        <a href="index.php?r=/site/login"><b>Scien</b>SYS</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Please fill out your email. A link to reset password will be sent there.</p>

        <div class="row">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <div class="col-lg-5">

                <div class="form-group">
                    <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

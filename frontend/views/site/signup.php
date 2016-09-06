<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions3 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-check form-control-feedback'></span>"
];

?>

<div class="login-box">
    <div class="login-logo">
        <a href="index.php?r=/site/login"><b>Scien</b>SYS</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Please fill out the following fields to signup</p>

        <div class="row">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username', $fieldOptions1)->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email', $fieldOptions2) ?>

            <?= $form->field($model, 'password', $fieldOptions3)->passwordInput() ?>

            <div class="col-lg-14 text-center">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'signup-button']) ?>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="social-auth-links text-center">
                <p>- Already an user -</p>
                <a href="/site/login" class="btn btn-block btn-primary btn-social btn-facebook btn-flat"> Login to ScienSys </a>
            </div>
        </div>
    </div>
</div>
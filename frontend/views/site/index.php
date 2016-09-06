<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Welcome to ScienSYS';
?>
<div class="site-index">

    <div class="info-box bg-green">
        <span class="info-box-icon"><i class="fa fa-user"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Personal Profile</span>
            <span class="info-box-number">100% Complete</span>
            <!-- The progress section is optional -->
            <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
            </div>
            <p>
                <?= Html::a('View', ['/user-detail/view-me'], ['class' => 'btn btn-xs btn-default pull-right']) ?>
                <?= Html::a('Update', ['/user-detail/update-me'], ['class' => 'btn btn-xs btn-default pull-right']) ?>
            </p>
        </div>
    </div>

    <div class="info-box bg-blue">
        <span class="info-box-icon"><i class="fa fa-building-o"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Business Profile</span>
            <span class="info-box-number">100% Complete</span>
            <!-- The progress section is optional -->
            <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
            </div>
            <p>
                <?= Html::a('View', ['/business-detail/view-me'], ['class' => 'btn btn-xs btn-default pull-right']) ?>
                <?= Html::a('Update', ['/business-detail/update-me'], ['class' => 'btn btn-xs btn-default pull-right']) ?>
            </p>
        </div>
    </div>

    <div class="info-box bg-orange">
        <span class="info-box-icon"><i class="fa fa-cloud-upload"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Documents Uploaded</span>
            <span class="info-box-number">33%</span>
            <div class="progress">
                <div class="progress-bar" style="width: 33%"></div>
            </div>
            <p>
                <?= Html::a('View', ['/document-detail/index'], ['class' => 'btn btn-xs btn-default pull-right']) ?>
            </p>
        </div>
    </div>

</div>

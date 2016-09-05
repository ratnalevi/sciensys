<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DocumentDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \common\models\DocumentDetail */
$this->title = 'Document Details';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="document-detail-index">

    <?php $docs = $dataProvider->getModels(); ?>

    <?php

    $form = ActiveForm::begin([
            'options'=>[
                'enctype'=>'multipart/form-data',
                'class' => 'document-upload-form'
            ],
        ]
    );

    echo $form->errorSummary($model);

    // or 'use kartik\file\FileInput' if you have only installed yii2-widget-fileinput in isolation
    Modal::begin([
        'header'=>'File Input inside Modal',
        'toggleButton' => [
            'label'=>'Upload More', 'class'=>'btn btn-success'
        ],
    ]);

    echo $form->field($model, 'file')->widget(FileInput::className(), [
        'name' => 'file',
        'pluginOptions' => [
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false,
            'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="glyphicon glyphicon-file"></i> ',
            'browseLabel' =>  'Select File'
        ],
        'options' => ['accept' => 'image/*']
    ]); ?>

    <div class="form-group text-center">
        <?= Html::submitButton( 'Upload', ['class' => 'btn btn-success']) ?>
    </div>

    <?php
    Modal::end();

    ActiveForm::end();
    ?>

    <br>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'tag' => 'div',
            'class' => 'list-wrapper',
            'id' => 'list-wrapper',
        ],
        'layout' => "{pager}\n{items}\n{summary}",
        'itemView' => '_list_item',
    ]);
    ?>

</div>
<?php

use yii\helpers\Url;
use kartik\detail\DetailView;

/* @var $this yii\web\View */

?>

    <?php
    $attributes = [
        [
            'attribute'=>'name',
            'label'=>'Uploaded by',
            'value' => $model->user->username,
            'displayOnly' => true,
        ],
        [
            'attribute'=>'name',
            'label'=>'Document Name',
            'displayOnly' => true,
        ],
        [
            'attribute'=>'file_type',
            'label'=>'File Type',
            'value' => $model->file_type,
            'displayOnly' => true,
        ],
        [
            'attribute'=>'file_size',
            'label'=>'File Size',
            'value' => ( $model->file_size / 1024 ) < 1024 ? number_format((float)$model->file_size / 1024 , 2, '.', '') . ' KB' : number_format((float)$model->file_size / ( 1024 * 1024 ) , 2, '.', '') . ' MB' ,
            'displayOnly' => true,
        ],
        [
            'attribute'=>'status',
            'label'=>'Verification Status',
            'format'=>'raw',
            'value'=> $model->status ? '<span class="label label-success">Approved</span>' : '<span class="label label-danger">Not Approved</span>',
            'type'=>DetailView::INPUT_DROPDOWN_LIST,
            'items' => ($model->status == 10 ) ? [ 1 => 'Approved' , 0 => 'Not Approved' ] : [ 0 => 'Not Approved' , 1 => 'Approved' ],
            'valueColOptions'=>['style'=>'width:30%']
        ],
        [
            'attribute'=>'id',
            'label' => 'ID',
            'format'=>'raw',
            'type' => DetailView::INPUT_DROPDOWN_LIST,
            'items' => [ $model->id => $model->id ],
            'value'=>'<span class="text-justify"><em>' . $model->id . '</em></span>',
        ],
       [
           'attribute'=>'created_at',
           'label' => '',
           'format'=>'raw',
           'value'=>'<span class="text-justify"><em><a href="' . $model->file_url . '" target="_blank"> Download</a></em></span>',
           'displayOnly' => true,
       ]
    ];

    echo DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
        'condensed'=>true,
        'hover'=>true,
        'bordered' => true,
        'striped' => true,
        'responsive' => true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'Document',
            'type'=> $model->status == 10 ? DetailView::TYPE_PRIMARY : DetailView::TYPE_DANGER ,
        ],
        'buttons1' => '{update}',
        'container' => ['id'=>'kv-demo-' . $model->id],
    ]);

    ?>




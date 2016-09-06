<?php

use yii\helpers\Url;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DocumentDetail */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Document Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-detail-view">
    <?php
    $attributes = [
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
            'value'=> $model->status ? '<span class="label label-success">Verified</span>' : '<span class="label label-danger">Not Verified</span>',
            'type'=>DetailView::INPUT_SWITCH,
            'widgetOptions' => [
                'pluginOptions' => [
                    'onText' => 'Yes',
                    'offText' => 'No',
                ]
            ],
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
        'buttons1' => '',
        'container' => ['id'=>'kv-demo'],
        'formOptions' => ['action' => Url::current(['/document-detail/index' => 'kv-demo'])] // your action to delete
    ]);

    ?>

</div>

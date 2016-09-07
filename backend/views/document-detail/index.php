<?php

use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DocumentDetailSearch */
/* @var $model \common\models\DocumentDetail */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Documents';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="document-index">

    <?php

    $form = ActiveForm::begin();

    echo $form->errorSummary($model);

    $gridColumns = [
        [
            'header'=>'Client ID',
            'value' => function( $model ){
                return $model->user->username;
            },
            'vAlign'=>'middle',
            'hAlign'=>'left',
            'width' => '20%',
            'pageSummary'=>true
        ],
        [
            'header'=>'Doc Type',
            'value' => function( $model ){
                return $model->docType->name;
            },
            'vAlign'=>'middle',
            'hAlign'=>'left',
            'width' => '20%',
            'pageSummary'=>true
        ],
        [
            'header'=>'File Name',
            'value' => function( $model ){
                return $model->name;
            },
            'vAlign'=>'middle',
            'hAlign'=>'left',
            'width' => '20%',
            'pageSummary'=>true
        ],
        [
            'header' => 'Perform Action',
            'class'=>'kartik\grid\EditableColumn',
            'attribute' => 'status',
            'editableOptions'=>[
                'name'=>'status',
                'value' => 0,
                'asPopover' => false,
                'header' => 'Status',
                'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                'data' => [0 => 'Review', 10 => 'Accept', -10 => 'Reject'],
                'options' => ['class'=>'form-control', 'prompt'=>'Select status...'],
                'displayValueConfig'=> [
                    '0' => 'Review',
                    '10' => '<i class="glyphicon glyphicon-thumbs-up"></i> Accepted',
                    '-10' => '<i class="glyphicon glyphicon-thumbs-down"></i> Rejected',
                ],
            ],
            'hAlign'=>'right',
            'vAlign'=>'middle',
            'width'=>'10%',
            'pageSummary'=>true
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'viewOptions' =>  ['class' => 'hide'],
            'deleteOptions' =>  ['class' => 'hide'],
            'buttons' => [
                'update' => function ($url, $model) {
                    return \yii\helpers\Html::a('Download', $model->file_url, [
                        'title' => 'Download',
                        'aria-label' => 'Download',
                        'data-pjax' => '0',
                        'class' => 'btn btn-md btn-info',
                    ]);
                }
            ],

        ],
    ];

    echo \kartik\grid\GridView::widget([
        'dataProvider'=>$dataProvider,
        'columns'=>$gridColumns
    ]);

    ?>
</div>

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BusinessDetail */

$this->title = "Business Details : " . $model->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="business-detail-view">

    <p>
        <?= Html::a('Update', ['update-me'], ['class' => 'btn btn-primary pull-right']) ?>
        <br>
        <br>
    </p>

    <?php

    $attributes = [
        [
            'group'=>true,
            'label'=>'Business Details',
            'rowOptions'=>['class'=>'info'],
            'groupOptions'=>['class'=>'text-center']
        ],
        [
            'attribute'=>'name',
            'value'=> ucfirst($model->name),
            'valueColOptions'=>['style'=>'width:30%'],
        ],
        [
            'attribute'=>'type_of_business',
            'value'=> ucfirst($model->typeOfBusiness->name),
            'valueColOptions'=>['style'=>'width:30%'],
        ],
        [
            'attribute'=>'form_of_business',
            'value'=> ucfirst($model->formOfBusiness->name),
            'valueColOptions'=>['style'=>'width:30%'],
        ],
        [
            'group'=>true,
            'label'=>'Address Details',
            'rowOptions'=>['class'=>'info'],
            'groupOptions'=>['class'=>'text-center']
        ],
        [
            'attribute'=>'address1',
            'format'=>'raw',
            'value'=>'<span class="text-justify"><em>' . $model->address1 . '</em></span>',
        ],
        [
            'attribute'=>'address2',
            'format'=>'raw',
            'value'=>'<span class="text-justify"><em>' . $model->address2 . '</em></span>',
        ],
        [
            'attribute'=>'address3',
            'format'=>'raw',
            'value'=>'<span class="text-justify"><em>' . $model->address3 . '</em></span>',
        ],
        [
            'columns' => [
                [
                    'attribute'=>'city_id',
                    'value'=> ucfirst($model->city->name),
                    'valueColOptions'=>['style'=>'width:30%'],
                ],
                [
                    'attribute'=>'pincode',
                    'format'=>'raw',
                    'value'=> $model->pincode,
                    'valueColOptions'=>['style'=>'width:30%'],
                ],
            ],
        ],
        [
            'group'=>true,
            'label'=>'Owner Details',
            'rowOptions'=>['class'=>'info'],
            'groupOptions'=>['class'=>'text-center']
        ],
        [
            'columns' => [
                [
                    'attribute'=>'owner1_name',
                    'value'=> ucfirst($model->owner1_name),
                    'valueColOptions'=>['style'=>'width:30%'],
                ],
                [
                    'attribute'=>'owner1_contact',
                    'format'=>'raw',
                    'value'=> $model->owner1_contact,
                    'valueColOptions'=>['style'=>'width:30%'],
                ],
            ],
        ],
        [
            'columns' => [
                [
                    'attribute'=>'owner2_name',
                    'value'=> ucfirst($model->owner2_name),
                    'valueColOptions'=>['style'=>'width:30%'],
                ],
                [
                    'attribute'=>'owner2_contact',
                    'format'=>'raw',
                    'value'=> $model->owner2_contact,
                    'valueColOptions'=>['style'=>'width:30%'],
                ],
            ],
        ],
        [
            'columns' => [
                [
                    'attribute'=>'owner3_name',
                    'value'=> ucfirst($model->owner3_name),
                    'valueColOptions'=>['style'=>'width:30%'],
                ],
                [
                    'attribute'=>'owner3_contact',
                    'format'=>'raw',
                    'value'=> $model->owner3_contact,
                    'valueColOptions'=>['style'=>'width:30%'],
                ],
            ],
        ],
    ];

    // View file rendering the widget
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
        'mode' => 'view',
        'container' => ['id'=>'kv-demo'],
        'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
    ]);

    ?>

</div>

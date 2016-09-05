<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserDetail */

$this->title = "Personal Details : " .  ucfirst($model->first_name) . " " . ucfirst($model->last_name);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-details-view">

    <p>
        <?= Html::a('Update', ['update-me'], ['class' => 'btn btn-primary pull-right']) ?>
        <br>
        <br>
    </p>

    <?php

    $attributes = [
        [
            'group'=>true,
            'label'=>'Biographic Details',
            'rowOptions'=>['class'=>'info'],
            'groupOptions'=>['class'=>'text-center']
        ],
        [
            'columns' => [
                [
                    'attribute'=>'first_name',
                    'value'=> ucfirst($model->first_name),
                    'valueColOptions'=>['style'=>'width:10%'],
                ],
                [
                    'attribute'=>'middle_name',
                    'format'=>'raw',
                    'value'=> ucfirst($model->middle_name),
                    'valueColOptions'=>['style'=>'width:10%'],
                ],
                [
                    'attribute'=>'last_name',
                    'format'=>'raw',
                    'value'=> ucfirst($model->last_name),
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
            ],
        ],
        [
            'attribute'=>'gender',
            'value'=> ( $model->gender == 1 ) ? "Female" : "Male",
        ],
        [
            'attribute'=>'dob',
            'format'=>'date',
            'type'=>DetailView::INPUT_DATE,
            'widgetOptions' => [
                'pluginOptions'=>['format'=>'yyyy-mm-dd']
            ],
        ],
        [
            'group'=>true,
            'label'=>'Contact Details',
            'rowOptions'=>['class'=>'info'],
            'groupOptions'=>['class'=>'text-center']
        ],
        [
            'attribute'=>'country_code',
            'label'=>'Country Code',
            'format'=> 'raw',
            'inputContainer' => ['class'=>'col-sm-6'],
        ],
        [
            'attribute'=>'mobile',
            'label'=>'Phone No.',
            'inputContainer' => ['class'=>'col-sm-6'],
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

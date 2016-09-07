<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;

/* @var $this yii\web\View */
/* @var $model common\models\BusinessDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="business-detail-form">

    <?php

    $resetButton = $model->isNewRecord  ? Html::resetButton('Reset', ['class'=>'btn btn-default']) : '';
    $action = $model->isNewRecord ? 'create' : 'update-me';
    $form = ActiveForm::begin([
        'type'=>ActiveForm::TYPE_VERTICAL,
        'action' => [ $action ]
    ]);

    echo $form->errorSummary($model);

    echo FormGrid::widget([
            'model'=>$model,
            'form'=>$form,
            'autoGenerateColumns'=>true,
            'rows'=>[
                [
                    'contentBefore'=>'<legend class="text-info"><small>Business Info</small></legend>',
                    'attributes'=>[       // 1 column layout
                        'name'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter business name ...']],
                    ],
                ],
                [
                    'attributes'=>[
                        'type_of_business'=>[
                            'type'=>Form::INPUT_DROPDOWN_LIST,
                            'items'=> \yii\helpers\ArrayHelper::map( \common\models\TypeOfBusiness::find()->all(), 'id', 'name'),
                        ],
                        'form_of_business'=>[
                            'type'=>Form::INPUT_DROPDOWN_LIST,
                            'items'=> \yii\helpers\ArrayHelper::map( \common\models\FormOfBusiness::find()->all(), 'id', 'name'),
                        ],
                    ]
                ],
                [
                    'contentBefore'=>'<legend class="text-info"><small>Business Address</small></legend>',
                    'attributes'=>[       // 1 column layout
                        'address1'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter address1...']],
                    ],
                ],
                [
                    'attributes'=>[       // 1 column layout
                        'address2'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter address2...']],
                    ],
                ],
                [
                    'attributes'=>[       // 1 column layout
                        'address3'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter address3...']],
                    ],
                ],
                [
                    'attributes'=>[
                        'city_id'=>[
                            'type'=>Form::INPUT_DROPDOWN_LIST,
                            'items'=> \yii\helpers\ArrayHelper::map( \common\models\City::find()->all(), 'id', 'name'),
                        ],
                        'pincode'=>[
                            'type'=>Form::INPUT_TEXT,
                            'options'=>['placeholder'=>'Zip...'],
                        ],
                    ],
                ],
                [
                    'contentBefore'=>'<legend class="text-info"><small>Owner Details</small></legend>',
                    'attributes'=>[       // 1 column layout
                        'owner1_name'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Owner Name ...']],
                        'owner1_contact'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Owner Contact ...']],
                    ],
                ],
                [
                    'attributes'=>[       // 1 column layout
                        'owner2_name'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Owner Name ...']],
                        'owner2_contact'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Owner Contact ...']],
                    ],
                ],
                [
                    'attributes'=>[       // 1 column layout
                        'owner3_name'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Owner Name ...']],
                        'owner3_contact'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Owner Contact ...']],
                    ],
                ],
                [
                    'attributes'=>[
                        'actions'=>[    // embed raw HTML content
                            'type'=>Form::INPUT_RAW,
                            'value'=>  '<div class="form-group text-center">' .
                                $resetButton . ' ' .
                                Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']).
                                '</div>'
                        ],
                    ],
                ],
            ],
        ]
    );

    ActiveForm::end(); ?>

</div>

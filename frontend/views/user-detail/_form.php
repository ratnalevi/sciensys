<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;

/* @var $this yii\web\View */
/* @var $model common\models\UserDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-details-form">

    <?php

    $resetButton = $model->isNewRecord  ? Html::resetButton('Reset', ['class'=>'btn btn-default']) : '';
    $action = $model->isNewRecord ? 'create' : 'update-me';
    $form = ActiveForm::begin([
        'type'=>ActiveForm::TYPE_VERTICAL,
        'action' =>[ $action ],
    ]);

    echo $form->errorSummary($model);

    echo FormGrid::widget([
            'model'=>$model,
            'form'=>$form,
            'autoGenerateColumns'=>true,
            'rows'=>[
                [
                    'contentBefore'=>'<legend class="text-info"><small>Biographic Details</small></legend>',
                    'attributes'=>[
                        'first_name'=>[
                            'type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'First Name'],
                        ],
                        'middle_name'=>[
                            'type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'First Name'],
                        ],
                        'last_name'=>[
                            'type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'First Name'],
                        ],
                    ]
                ],
                [
                    'attributes'=>[
                        'gender'=>[
                            'type'=>Form::INPUT_DROPDOWN_LIST,
                            'items'=> ['Female', 'Male'],
                        ],
                        'dob'=>[
                            'type'=>Form::INPUT_WIDGET,
                            'widgetClass'=>'\kartik\widgets\DatePicker',
                            'hint'=>'Enter birthday',
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'dd-mm-yyyy',
                            ]
                        ],
                    ],
                ],
                [
                    'attributes'=>[
                        'country_code'=>[
                            'type'=>Form::INPUT_DROPDOWN_LIST,
                            'items'=> ['91' => '+91'],
                        ],
                        'mobile'=>[
                            'type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Mobile Number...']
                        ],
                    ],
                ],
                [
                    'contentBefore'=>'<legend class="text-info"><small>Address Info</small></legend>',
                    'attributes'=>[       // 1 column layout
                        'address'=>['type'=>Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter address...']],
                    ],
                ],
                [
                    'contentBefore'=>'<legend class="text-info"><small>Business Details</small></legend>',
                    'attributes'=>[
                        'company_name'=>[
                            'type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'First Name'],
                        ],
                    ]
                ],
                [
                    'attributes'=>[
                        'form_of_business'=>[
                            'type'=>Form::INPUT_DROPDOWN_LIST,
                            'items'=> \yii\helpers\ArrayHelper::map( \common\models\FormOfBusiness::find()->all(), 'id', 'name'),
                        ],
                        'type_of_business'=>[
                            'type'=>Form::INPUT_DROPDOWN_LIST,
                            'items'=> \yii\helpers\ArrayHelper::map( \common\models\TypeOfBusiness::find()->all(), 'id', 'name'),
                        ],
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

    ActiveForm::end();

    ?>

</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model \common\models\UserDetail*/
/* @var $searchModel backend\models\UserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-detail-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php

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
            'header'=>'Client Name',
            'value' => function( $model ){
                return $model->getFullName();
            },
            'vAlign'=>'middle',
            'hAlign'=>'left',
            'width' => '20%',
            'pageSummary'=>true
        ],
        [
            'header'=>'Company Name',
            'value' => function( $model ){
                return $model->company_name;
            },
            'vAlign'=>'middle',
            'hAlign'=>'left',
            'width' => '20%',
            'pageSummary'=>true
        ],
        [
            'header'=>'Type',
            'value' => function( $model ){
                return $model->typeOfBusiness->name;
            },
            'vAlign'=>'middle',
            'hAlign'=>'left',
            'width' => '20%',
            'pageSummary'=>true
        ],
        [
            'header'=>'Form',
            'value' => function( $model ){
                return $model->formOfBusiness->name;
            },
            'vAlign'=>'middle',
            'hAlign'=>'left',
            'width' => '20%',
            'pageSummary'=>true
        ],
        [
            'header'=>'Mobile',
            'value' => function( $model ){
                return $model->mobile;
            },
            'vAlign'=>'middle',
            'hAlign'=>'left',
            'width' => '20%',
            'pageSummary'=>true
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'viewOptions' =>  ['class' => 'hide'],
            'deleteOptions' =>  ['class' => 'hide'],
            'buttons' => [
                'update' => function ($url, $model) {
                    return \yii\helpers\Html::a('View Docs', 'index.php?r=user-detail/view&id=' . $model->id , [
                        'title' => 'View Docs',
                        'aria-label' => 'View Docs',
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

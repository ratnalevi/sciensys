<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DocumentDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Document Details';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="document-detail-index">

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
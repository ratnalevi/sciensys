<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DocumentDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \common\models\DocumentDetail */
/* @var $personal \common\models\UserDetail*/
/* @var $business \common\models\BusinessDetail */
$this->title = 'Document Details';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="document-detail-index">

        <?php
        $msg = '';
        if( $personal !== null && $business !== null ){
        echo Html::a('<i class="fa glyphicon glyphicon-file"></i> Final Document ', ['/document-detail/get-report'], [
            'class'=>'btn btn-primary',
            'target'=>'_blank',
            'data-toggle'=>'tooltip',
            'title'=>'Please download your final business document'
        ]);
        }else{
            if( $personal === null ){
                $msg = 'Please fill your personal info to continue with document upload<br><br><br><br><br>';
            }
            if( $business === null ){
                $msg .= 'Please fill your business info to continue with document upload<br><br><br><br>';
            }
            echo '<p style="font-size: medium; font-style: oblique">Please fill your personal details / business details to download the final assessment document</p>';
        }

    $docs = $dataProvider->getModels();
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
        'header'=>'Upload Document',
        'id' => 'doc_upload',
        'toggleButton' => [
            'label'=>'Upload More', 'class'=>'btn btn-success hidden'
        ],
    ]);

    $docTypes = \common\models\DocumentType::find()->all();

    ?>

    <?php

    echo $form->field($model, 'doc_type_id')->hiddenInput(['id' => 'doc_upload_type_id'])->label(false);

    echo $form->field($model, 'file')->widget(FileInput::className(), [
        'name' => 'file',
        'pluginOptions' => [
            'showCaption' => true,
            'showRemove' => false,
            'showUpload' => false,
            'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="glyphicon glyphicon-file"></i> ',
            'browseLabel' =>  'Select File'
        ],
        'options' => ['accept' => 'application/msword, text/pdf']
    ])->label('');
    ?>

    <div class="form-group text-center">
        <?= Html::submitButton( 'Upload', ['class' => 'btn btn-success']) ?>
    </div>

    <?php
    Modal::end();

    ActiveForm::end();
    ?>

    <br>

    <div class="tg-wrap">
        <table id="tg-j3huI" class="tg">
            <tr>
                <th class="tg-hvxd">Step</th>
                <th class="tg-hvxd">User Status</th>
                <th class="tg-hvxd">Admin Status</th>
                <th class="tg-hvxd">Download</th>
                <th class="tg-hvxd">Upload</th>
                <th class="tg-k3mp">Status</th>
            </tr>
            <?php

            $userStatus = '';
            $adminStatus = '';
            $downloadDisable = '';
            $uploadEnableNext = '';
            $uploadDisable = '';

            for ( $i = 0 ; $i < sizeof( $docTypes ); $i++ ){

                if( !isset( $docs[$docTypes[$i]->id ] ) ){
                    if( $i == 0 || $uploadEnableNext ){
                        $userStatus = 'Pending submission';
                        $adminStatus = 'Awaiting docs from user';
                        $uploadDisable = '';
                        $uploadEnableNext = 0;
                    }
                    else{
                        $userStatus = 'Awaiting on step : ' . $i ;
                        $adminStatus = 'Awaiting docs from user';
                        $uploadDisable = 'disabled';
                    }
                    $downloadDisable = ' disabled ';
                }else{
                    $uploadEnableNext = 1;
                    $userStatus = 'Uploaded by user';
                    $adminStatus = $docs[$docTypes[$i]->id ]->status == \common\models\DocumentDetail::FILE_ACTIVE ? 'Approved by admin' : 'Under review';
                }

                echo '<tr>';
                echo '<td class="tg-hjma">' . 'Step : ' . ( $i + 1 ) . ' - ' . $docTypes[$i]->name . '</td>';
                echo '<td class="tg-hjma">' . $userStatus . '</td>';
                echo '<td class="tg-hjma">' . $adminStatus . '</td>';
                echo '<td class="tg-hjma">' . '<a href="' . $docs[ $docTypes[$i]->id ]->file_url . '"><button type="button"  class="btn btn-sm btn-success" ' . $downloadDisable . '>Download</button></a>' . '</td>';
                echo '<td class="tg-hjma">' . '<button type="button"  class="btn btn-sm btn-info" id="' . $docTypes[$i]->id . '-' . $docTypes[$i]->name . '"'. $uploadDisable. ' onclick="loadModal(this)">Upload</button>' . '</td>';
                echo '<td class="tg-4s4s">' . \kartik\widgets\SwitchInput::widget([
                        'name' => 'status',
                        'value' => ( $docs[$docTypes[$i]->id ]->status == \common\models\DocumentDetail::FILE_ACTIVE ),
                        'disabled' => true,
                        'pluginOptions' => [
                            'size' => 'large',
                            'onColor' => 'success',
                            'offColor' => 'danger',
                            'onText' => 'Approved',
                            'offText' => 'Processing'
                        ]
                    ]) . '</td>';
                echo '</tr>';
            }
            ?>
        </table>

        <?php
        if( $personal === null || $business === null ){
            ?>
        <div id="bg_mask">
            <div id="frontlayer"><br/><br/>
                <p style="font-size: large; font-style: inherit; "><?= $msg ?></p>
            </div>
        </div>
        <?php } ?>
    </div>

    <script type="text/javascript" charset="utf-8">var TgTableSort=window.TgTableSort||function(n,t){"use strict";function r(n,t){for(var e=[],o=n.childNodes,i=0;i<o.length;++i){var u=o[i];if("."==t.substring(0,1)){var a=t.substring(1);f(u,a)&&e.push(u)}else u.nodeName.toLowerCase()==t&&e.push(u);var c=r(u,t);e=e.concat(c)}return e}function e(n,t){var e=[],o=r(n,"tr");return o.forEach(function(n){var o=r(n,"td");t>=0&&t<o.length&&e.push(o[t])}),e}function o(n){return n.textContent||n.innerText||""}function i(n){return n.innerHTML||""}function u(n,t){var r=e(n,t);return r.map(o)}function a(n,t){var r=e(n,t);return r.map(i)}function c(n){var t=n.className||"";return t.match(/\S+/g)||[]}function f(n,t){return-1!=c(n).indexOf(t)}function s(n,t){f(n,t)||(n.className+=" "+t)}function d(n,t){if(f(n,t)){var r=c(n),e=r.indexOf(t);r.splice(e,1),n.className=r.join(" ")}}function v(n){d(n,L),d(n,E)}function l(n,t,e){r(n,"."+E).map(v),r(n,"."+L).map(v),e==T?s(t,E):s(t,L)}function g(n){return function(t,r){var e=n*t.str.localeCompare(r.str);return 0==e&&(e=t.index-r.index),e}}function h(n){return function(t,r){var e=+t.str,o=+r.str;return e==o?t.index-r.index:n*(e-o)}}function m(n,t,r){var e=u(n,t),o=e.map(function(n,t){return{str:n,index:t}}),i=e&&-1==e.map(isNaN).indexOf(!0),a=i?h(r):g(r);return o.sort(a),o.map(function(n){return n.index})}function p(n,t,r,o){for(var i=f(o,E)?N:T,u=m(n,r,i),c=0;t>c;++c){var s=e(n,c),d=a(n,c);s.forEach(function(n,t){n.innerHTML=d[u[t]]})}l(n,o,i)}function x(n,t){var r=t.length;t.forEach(function(t,e){t.addEventListener("click",function(){p(n,r,e,t)}),s(t,"tg-sort-header")})}var T=1,N=-1,E="tg-sort-asc",L="tg-sort-desc";return function(t){var e=n.getElementById(t),o=r(e,"tr"),i=o.length>0?r(o[0],"td"):[];0==i.length&&(i=r(o[0],"th"));for(var u=1;u<o.length;++u){var a=r(o[u],"td");if(a.length!=i.length)return}x(e,i)}}(document);document.addEventListener("DOMContentLoaded",function(n){TgTableSort("tg-j3huI")});</script>

</div>
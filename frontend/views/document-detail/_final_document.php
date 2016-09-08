<?php

/* @var $this yii\web\View */
/* @var $business \common\models\BusinessDetail */
/* @var $personal \common\models\UserDetail */

$this->title = ""
?>


<div class="final-document-index">

    <div class="final-document-title text-center">Letter of Acceptance</div>
    <div class="tg-wrap"><table class="tg">
            <tr>
                <th class="tg-vxmf" colspan="4">Business Details</th>
            </tr>
            <tr>
                <td class="tg-qj8c">Name of business</td>
                <td class="tg-yw4l" colspan="3"><?= $personal->company_name ?></td>
            </tr>
            <tr>
                <td class="tg-qj8c">Type of Business</td>
                <td class="tg-yw4l"><?= $personal->typeOfBusiness->name ?></td>
                <td class="tg-qj8c">Form of Business</td>
                <td class="tg-yw4l"><?= $personal->formOfBusiness->name ?></td>
            </tr>
            <tr>
                <td class="tg-qj8c" rowspan="2">Address</td>
                <td class="tg-yw4l" colspan="3" rowspan="2"> <?= $personal->address ?><br></td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td class="tg-vxmf" colspan="4" style="background-color:#ffffff;"></td>
            </tr>
            <tr>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
            </tr>
            <tr>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
            </tr>
            <tr>
                <td class="tg-vxmf" colspan="4">Filed By</td>
            </tr>
            <tr>
                <td class="tg-qj8c">Name</td>
                <td class="tg-yw4l"><?= $personal->getFullName() ?></td>
                <td class="tg-yw4l" colspan="2" rowspan="2"></td>
            </tr>
            <tr>
                <td class="tg-qj8c">Contact</td>
                <td class="tg-yw4l"><?= $personal->mobile ?></td>
            </tr>
            <tr>
                <td class="tg-yw4l" colspan="2" rowspan="3"></td>
                <td class="tg-p84l" colspan="2">Yours sincerely</td>
            </tr>
            <tr>
                <td class="tg-lqy6" colspan="2" rowspan="2">Please sign here</td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
            </tr>
            <tr>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
            </tr>
            <tr>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
            </tr>
            <tr>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
            </tr>
            <tr>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
            </tr>
        </table></div>

</div>

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
                <td class="tg-yw4l" colspan="3"><?= $business->name ?></td>
            </tr>
            <tr>
                <td class="tg-qj8c">Type of Business</td>
                <td class="tg-yw4l"><?= $business->type_of_business ?></td>
                <td class="tg-qj8c">Form of Business</td>
                <td class="tg-yw4l"><?= $business->form_of_business ?></td>
            </tr>
            <tr>
                <td class="tg-qj8c" rowspan="2">Address</td>
                <td class="tg-yw4l" colspan="3" rowspan="2"> <?= $business->address1?><br><?= $business->address2?><br><?= $business->address3 ?></td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td class="tg-vxmf" colspan="4" style="background-color:#ffffff;"></td>
            </tr>
            <tr>
                <td class="tg-sbnk" colspan="4">Partner ID : 1</td>
            </tr>
            <tr>
                <td class="tg-qj8c">Name</td>
                <td class="tg-yw4l"><?= $business->owner1_name ?></td>
                <td class="tg-qj8c">Contact</td>
                <td class="tg-yw4l"><?= $business->owner1_contact ?></td>
            </tr>
            <tr>
                <td class="tg-sbnk" colspan="4">Partner ID : 2</td>
            </tr>
            <tr>
                <td class="tg-qj8c">Name</td>
                <td class="tg-yw4l"><?= $business->owner2_name ?></td>
                <td class="tg-qj8c">Contact</td>
                <td class="tg-yw4l"><?= $business->owner2_contact ?></td>
            </tr>
            <tr>
                <td class="tg-sbnk" colspan="4">Partner ID : 3</td>
            </tr>
            <tr>
                <td class="tg-qj8c">Name</td>
                <td class="tg-yw4l"><?= $business->owner3_name ?></td>
                <td class="tg-qj8c">Contact</td>
                <td class="tg-yw4l"><?= $business->owner3_contact ?></td>
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

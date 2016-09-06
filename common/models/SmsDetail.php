<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "qs_sms_detail".
 *
 * @property integer $id
 * @property string $sender_name
 * @property integer $send_to
 * @property string $message
 * @property integer $batch_id
 * @property integer $msg_id
 * @property string $msg_status
 */
class SmsDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qs_sms_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender_name', 'send_to', 'message', 'batch_id', 'msg_id', 'msg_status'], 'required'],
            [['send_to', 'batch_id', 'msg_id'], 'integer'],
            [['sender_name'], 'string', 'max' => 64],
            [['message'], 'string', 'max' => 255],
            [['msg_status'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_name' => 'Sender Name',
            'send_to' => 'Send To',
            'message' => 'Message',
            'batch_id' => 'Batch ID',
            'msg_id' => 'Msg ID',
            'msg_status' => 'Msg Status',
        ];
    }
}

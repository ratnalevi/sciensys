<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property integer $from_user
 * @property integer $to_user
 * @property string $message
 * @property integer $document_id
 * @property integer $is_read
 * @property integer $created_at
 * @property integer $read_at
 *
 * @property User $fromUser
 * @property User $toUser
 * @property DocumentDetail $document
 */
class Notification extends \yii\db\ActiveRecord
{
    const READ = 1;
    const UNREAD = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_user', 'to_user', 'document_id', 'is_read', 'created_at', 'read_at'], 'integer'],
            [['message'], 'string', 'max' => 255],
            [['from_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_user' => 'id']],
            [['to_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_user' => 'id']],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentDetail::className(), 'targetAttribute' => ['document_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_user' => 'From User',
            'to_user' => 'To User',
            'message' => 'Message',
            'document_id' => 'Document ID',
            'is_read' => 'Is Read',
            'created_at' => 'Created At',
            'read_at' => 'Read At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument()
    {
        return $this->hasOne(DocumentDetail::className(), ['id' => 'document_id']);
    }
}

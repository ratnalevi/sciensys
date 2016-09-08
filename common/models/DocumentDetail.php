<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "document_detail".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $file_url
 * @property string $file_type
 * @property integer $file_size
 * @property integer $doc_type_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property DocumentType $docType
 * @property Notification[] $notifications
 */
class DocumentDetail extends \yii\db\ActiveRecord
{
    const NEW_FILE = 0;
    const APPROVE = 10;
    const REJECT = -10;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'file_url', 'file_type', 'file_size', 'doc_type_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'file_size', 'doc_type_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['file_url'], 'string', 'max' => 256],
            [['file_type'], 'string', 'max' => 64],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['doc_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentType::className(), 'targetAttribute' => ['doc_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'file_url' => 'File Url',
            'file_type' => 'File Type',
            'file_size' => 'File Size',
            'doc_type_id' => 'Doc Type ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocType()
    {
        return $this->hasOne(DocumentType::className(), ['id' => 'doc_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notification::className(), ['document_id' => 'id']);
    }
}

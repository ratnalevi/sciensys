<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "document_type".
 *
 * @property integer $id
 * @property string $name
 * @property integer $is_mandatory
 *
 * @property DocumentDetail[] $documentDetails
 */
class DocumentType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_mandatory'], 'integer'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'is_mandatory' => 'Is Mandatory',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentDetails()
    {
        return $this->hasMany(DocumentDetail::className(), ['doc_type_id' => 'id']);
    }
}

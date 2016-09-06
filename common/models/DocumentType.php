<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "qs_document_type".
 *
 * @property integer $id
 * @property string $name
 * @property integer $is_mandatory
 *
 * @property DocumentDetail[] $DocumentDetails
 */
class DocumentType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qs_document_type';
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

    /**
     * @inheritdoc
     * @return DocumentTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DocumentTypeQuery(get_called_class());
    }
}

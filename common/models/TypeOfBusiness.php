<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "qs_type_of_business".
 *
 * @property integer $id
 * @property string $name
 *
 * @property QsBusinessDetail[] $qsBusinessDetails
 */
class TypeOfBusiness extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qs_type_of_business';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQsBusinessDetails()
    {
        return $this->hasMany(QsBusinessDetail::className(), ['type_of_business' => 'id']);
    }

    /**
     * @inheritdoc
     * @return TypeOfBusinessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TypeOfBusinessQuery(get_called_class());
    }
}

<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "qs_country".
 *
 * @property integer $id
 * @property string $name
 * @property string $iso_code
 * @property string $iso_code1
 * @property string $iso_code2
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qs_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'iso_code', 'iso_code1', 'iso_code2'], 'required'],
            [['name'], 'string', 'max' => 64],
            [['iso_code', 'iso_code1', 'iso_code2'], 'string', 'max' => 8],
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
            'iso_code' => 'Iso Code',
            'iso_code1' => 'Iso Code1',
            'iso_code2' => 'Iso Code2',
        ];
    }

    /**
     * @inheritdoc
     * @return CountryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountryQuery(get_called_class());
    }
}

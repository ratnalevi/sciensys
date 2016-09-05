<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "qs_state".
 *
 * @property integer $id
 * @property string $name
 * @property integer $country_id
 *
 * @property QsCity[] $qsCities
 */
class State extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qs_state';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'country_id'], 'required'],
            [['country_id'], 'integer'],
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
            'country_id' => 'Country ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQsCities()
    {
        return $this->hasMany(QsCity::className(), ['state_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return StateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StateQuery(get_called_class());
    }
}

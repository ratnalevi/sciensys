<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "qs_city".
 *
 * @property integer $id
 * @property string $name
 * @property integer $state_id
 *
 * @property QsState $state
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qs_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'state_id'], 'required'],
            [['state_id'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => QsState::className(), 'targetAttribute' => ['state_id' => 'id']],
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
            'state_id' => 'State ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(QsState::className(), ['id' => 'state_id']);
    }

    /**
     * @inheritdoc
     * @return CityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CityQuery(get_called_class());
    }
}

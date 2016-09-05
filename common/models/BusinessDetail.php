<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "qs_business_detail".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $type_of_business
 * @property integer $form_of_business
 * @property string $owner1_name
 * @property string $owner1_contact
 * @property string $owner2_name
 * @property string $owner2_contact
 * @property string $owner3_name
 * @property string $owner3_contact
 * @property string $address1
 * @property string $address2
 * @property string $address3
 * @property integer $city_id
 * @property integer $pincode
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property FormOfBusiness $formOfBusiness
 * @property TypeOfBusiness $typeOfBusiness
 * @property City $city
 * @property User $user
 */
class BusinessDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qs_business_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'type_of_business', 'form_of_business', 'owner1_name', 'owner1_contact', 'address1', 'city_id', 'pincode'], 'required'],
            [['user_id', 'type_of_business', 'form_of_business', 'city_id', 'pincode', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['owner1_name', 'owner2_name', 'owner3_name', 'address1', 'address2', 'address3'], 'string', 'max' => 64],
            [['owner1_contact', 'owner2_contact', 'owner3_contact'], 'string', 'max' => 16],
            [['form_of_business'], 'exist', 'skipOnError' => true, 'targetClass' => FormOfBusiness::className(), 'targetAttribute' => ['form_of_business' => 'id']],
            [['type_of_business'], 'exist', 'skipOnError' => true, 'targetClass' => TypeOfBusiness::className(), 'targetAttribute' => ['type_of_business' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'type_of_business' => 'Type Of Business',
            'form_of_business' => 'Form Of Business',
            'owner1_name' => 'Owner1 Name',
            'owner1_contact' => 'Owner1 Contact',
            'owner2_name' => 'Owner2 Name',
            'owner2_contact' => 'Owner2 Contact',
            'owner3_name' => 'Owner3 Name',
            'owner3_contact' => 'Owner3 Contact',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'address3' => 'Address3',
            'city_id' => 'City ID',
            'pincode' => 'Pincode',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormOfBusiness()
    {
        return $this->hasOne(FormOfBusiness::className(), ['id' => 'form_of_business']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeOfBusiness()
    {
        return $this->hasOne(TypeOfBusiness::className(), ['id' => 'type_of_business']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return BusinessDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BusinessDetailQuery(get_called_class());
    }
}

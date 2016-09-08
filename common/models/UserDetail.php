<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_detail".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $company_name
 * @property integer $form_of_business
 * @property integer $type_of_business
 * @property string $country_code
 * @property string $mobile
 * @property string $dob
 * @property integer $gender
 * @property string $address
 * @property integer $pincode
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property FormOfBusiness $formOfBusiness
 * @property TypeOfBusiness $typeOfBusiness
 * @property User $user
 */
class UserDetail extends \yii\db\ActiveRecord
{
    public $fullName = '';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'first_name', 'middle_name', 'last_name', 'company_name', 'form_of_business', 'type_of_business', 'dob', 'address'], 'required'],
            [['user_id', 'form_of_business', 'type_of_business', 'gender', 'pincode', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 32],
            [['company_name', 'address'], 'string', 'max' => 64],
            [['country_code'], 'string', 'max' => 8],
            [['mobile', 'dob'], 'string', 'max' => 16],
            [['form_of_business'], 'exist', 'skipOnError' => true, 'targetClass' => FormOfBusiness::className(), 'targetAttribute' => ['form_of_business' => 'id']],
            [['type_of_business'], 'exist', 'skipOnError' => true, 'targetClass' => TypeOfBusiness::className(), 'targetAttribute' => ['type_of_business' => 'id']],
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
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'company_name' => 'Company Name',
            'form_of_business' => 'Form Of Business',
            'type_of_business' => 'Type Of Business',
            'country_code' => 'Country Code',
            'mobile' => 'Mobile',
            'dob' => 'Dob',
            'gender' => 'Gender',
            'address' => 'Address',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return join(' ', [ucfirst($this->first_name),ucfirst($this->middle_name),ucfirst($this->last_name)]);
    }
}

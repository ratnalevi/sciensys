<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "qs_user_detail".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $country_code
 * @property integer $mobile
 * @property string $dob
 * @property integer $gender
 * @property string $address1
 * @property string $address2
 * @property string $address3
 * @property integer $city_id
 * @property string $pincode
 * @property integer $created_at
 * @property integer $updated_at
 */
class UserDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qs_user_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'first_name', 'middle_name', 'last_name', 'dob', 'address1', 'city_id', 'pincode'], 'required'],
            [['user_id', 'mobile', 'gender', 'city_id', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 32],
            [['country_code'], 'string', 'max' => 8],
            [['dob', 'pincode'], 'string', 'max' => 16],
            [['address1', 'address2', 'address3'], 'string', 'max' => 64],
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
            'country_code' => 'Country Code',
            'mobile' => 'Mobile',
            'dob' => 'Dob',
            'gender' => 'Gender',
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
     * @inheritdoc
     * @return UserDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserDetailQuery(get_called_class());
    }

    /**
     * @inheritdoc
     * @return UserDetail based on ID
     */
    public static function findByUserId($id){
        return UserDetail::find()->andWhere(['user_id' => $id])->one();
    }

    public function getCity(){
        return City::find()->andWhere(['id' => $this->city_id])->one();
    }

    public function getFullName(){
        return join(' ' , [ucfirst( $this->first_name ), ucfirst( $this->middle_name ), ucfirst( $this->last_name ) ]);
    }
}

<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;


/**
 * This is the model class for table "qs_document_detail".
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
 */
class DocumentDetail extends \yii\db\ActiveRecord
{

    public $file;

    const FILE_ACTIVE = 10;
    const FILE_NEW = 0;
    const FILE_INACTIVE = -10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qs_document_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'safe'],
            [['file'], 'file', 'extensions'=>'jpg, gif, png'],

            [['user_id', 'name', 'file_url', 'file_type', 'file_size','doc_type_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'file_size', 'status', 'created_at', 'updated_at'], 'integer'],
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

    /**
     * @inheritdoc
     * @return DocumentDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DocumentDetailQuery(get_called_class());
    }

    // EXTRA METHODS

    public function url(){
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['REQUEST_URI']
        );
    }

    public function submit(){

        $uploadedFile = UploadedFile::getInstance($this, 'file');

        if (sizeof($uploadedFile) <= 0 ) {
            $this->addErrors( ['Please upload a file']);
            return $this ;
        }

        if ($uploadedFile->error != 0 ) {
            $this->addErrors( ['Unknown Error in uploading file. Please try again later']);
            return $this ;
        }

        $path = Yii::$app->basePath . '/web/uploads/' . $uploadedFile->name;

        $url = $this->url();
        $url = str_replace('index', 'download', $url);
        $url .= '&file_name=' . $uploadedFile->name;

        $this->name = $uploadedFile->name;
        $this->file_url = $url;
        $this->user_id = Yii::$app->user->id;
        $this->file_type = $uploadedFile->type;
        $this->file_size = $uploadedFile->size;
        $this->status = static::FILE_NEW;
        $this->updated_at = time();

        if($this->save()){
            $uploadedFile->saveAs($path);
        }

        return $this;
    }
}

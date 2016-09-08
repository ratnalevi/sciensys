<?php

namespace frontend\models;

use common\models\DocumentDetail;
use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

/**
 * DocumentDetailForm implements the form for DocumentDetail model.
 */

class DocumentDetailForm extends  Model {

    public $file;
    public $doc_type_id;

    public function rules()
    {
        return [
            [['file'], 'safe'],
            [['doc_type_id'], 'integer'],
            [['file'], 'file', 'extensions'=>'docx, doc, pdf'],
        ];
    }

    public function url(){
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['REQUEST_URI']
        );
    }

    public function submit(){

        if( !$this->validate() ){
            return null;
        }

        $uploadedFile = UploadedFile::getInstance($this, 'file');

        if (sizeof($uploadedFile) <= 0 ) {
            $this->addErrors( ['Please upload a file']);
            return $this ;
        }

        if ($uploadedFile->error != 0 ) {
            $this->addErrors( ['Unknown Error in uploading file. Please try again later']);
            return $this ;
        }

        $name = explode('.', $uploadedFile->name );
        $ext = $name[1];
        $savedName = Yii::$app->security->generateRandomString(10);
        $savedName .= '.' . $ext;
        $path = Yii::$app->basePath . '/web/uploads/' .$savedName;

        $url = explode('?', $this->url() );

        $url = $url[0] . '?' . str_replace('index', 'download', $url[1]);
        $url .= '&file_name=' . $savedName;

        $doc = DocumentDetail::find()
            ->andWhere(['doc_type_id' => $this->doc_type_id])
            ->andWhere(['user_id' => Yii::$app->user->id ])
            ->one();

        if( $doc === null ){
            $doc = new DocumentDetail();
            $doc->created_at = time();
        }

        $doc->name = $uploadedFile->name;
        $doc->file_url = $url;
        $doc->doc_type_id = $this->doc_type_id;
        $doc->user_id = Yii::$app->user->id;
        $doc->file_type = $uploadedFile->type;
        $doc->file_size = $uploadedFile->size;
        $doc->status = DocumentDetail::NEW_FILE;
        $doc->updated_at = time();

        if($doc->save()){
            $uploadedFile->saveAs($path);
        }else{
            die(print_r($doc->errors));
        }

        return $doc;
    }

}
?>
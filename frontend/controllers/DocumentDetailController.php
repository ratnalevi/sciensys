<?php

namespace frontend\controllers;

use common\helpers\FileHelper;
use common\models\User;
use Yii;
use common\models\DocumentDetail;
use frontend\models\DocumentDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use common\helpers\TextLocal;
use common\models\Notification;
use common\models\UserDetail;


/**
 * DocumentDetailController implements the CRUD actions for DocumentDetail model.
 */
class DocumentDetailController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function sendSMS( $numbers, $message ){

        $username = 'levi@pluggd.co';
        $hash = '1be9c8b470eb085bb20442bacb4ef4b61c09eba3';

        $sender = urlencode('TXTLCL');
        $message = rawurlencode( $message );

        $numbers = implode(',', $numbers);

        $data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

        $ch = curl_init('http://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * Lists all DocumentDetail models.
     * @return mixed
     */
    public function actionIndex()
    {

        /*
         * Code to send sms using TextLocal
         *
        $message = 'Hi Levi, Thanks for signing up on our application';
        $contacts = [9566018299];
        $smsResponse = $this->sendSMS($contacts, $message);
        */

        $searchModel = new DocumentDetailSearch();
        $model = new DocumentDetail();

        $post = Yii::$app->request->post();
        // process ajax delete
        if (Yii::$app->request->isAjax && isset($post['kvdelete']))
        {
            $id = $post['id'];
            $doc = DocumentDetail::find()->andWhere(['id' => $id])->one();
            if( $doc !== null ) {
                $doc->delete();
                echo Json::encode([
                    'success' => true,
                    'messages' => [
                        'kv-detail-info' => 'Document successfully deleted',
                    ]
                ]);
            }
            else{
                echo Json::encode([
                    'success' => false,
                    'messages' => [
                        'kv-detail-info' => 'Document with given ID does not exist',
                    ]
                ]);
            }
            return;
        }

        if( Yii::$app->request->isPost ){
            $params = Yii::$app->request->post('DocumentDetail');
            if( isset( $params['file'] ) ){
                if (( $model->submit()) !== null && !$model->hasErrors()) {

                    $userDetail = UserDetail::find()->andWhere(['user_id' => $model->user_id])->one();

                    $message = '<b>' . $model->name . '</b> has been uploaded by ' . $userDetail->getFullName() . " Review required";

                    $admin = User::find()->andWhere(['type' => User::ROOT_USER ])->one();

                    $notification = new Notification();
                    $notification->from_user = Yii::$app->user->id;
                    $notification->to_user = $admin->id;
                    $notification->message = $message;
                    $notification->document_id = $model->id;
                    $notification->is_read = Notification::UNREAD;
                    $notification->created_at = time();
                    $notification->read_at = 0;

                    // send a message to user who uploaded the document

                    /*
                    if( $userDetail !== null && $userDetail->mobile === '' ) {
                        $numbers = $userDetail->mobile;
                        $smsResponse = $this->sendSMS($numbers, $message );
                    }
                    */

                    if( !$notification->save() ){
                        Yii::$app->session->setFlash('kv-detail-error', 'Updated successfully, but notification failed');
                    }

                    Yii::$app->getSession()->setFlash('success', 'Saved successfully');
                }
            }else {

                $model = DocumentDetail::find()->andWhere(['id' => $params['id']])->one();
                $model->status = $params['status'] == 1 ? 10 : 0;

                if (!$model->save()) {
                    Yii::$app->session->setFlash('kv-detail-error', 'Updation Failed');
                }
            }
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * Displays a single DocumentDetail model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDownload(){
        $params = Yii::$app->request->get();
        $fileName = $params['file_name'];
        $file_path= $path = Yii::$app->basePath . '/web/uploads/'. $fileName ;
        FileHelper::output_file($file_path, ''. $fileName .'', 'text/plain');
        return true;
    }

    /**
     * Deletes an existing DocumentDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DocumentDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DocumentDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DocumentDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace backend\controllers;

use common\helpers\FileHelper;
use common\models\Notification;
use common\models\UserDetail;
use Yii;
use common\models\DocumentDetail;
use backend\models\DocumentDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use common\helpers\TextLocal;

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

        if( Yii::$app->request->isPost ){
            $params = Yii::$app->request->post('DocumentDetail');

            $model = DocumentDetail::find()->andWhere(['id' => $params['id']])->one();
            $userDetail = UserDetail::find()->andWhere(['user_id' => $model->user_id])->one();

            $model->status = $params['status'] == 1 ? 10 : 0;
            $verification = $params['status'] == 1 ? 'approved' : 'not approved';

            if (!$model->save()) {
                Yii::$app->session->setFlash('kv-detail-error', 'Updation Failed');
            }

            // Put a notification

            $message = '<b>' . $model->name . '</b> has been ' . $verification . ' by <b>Admin</b>. Please review and proceed';

            $notification = new Notification();
            $notification->from_user = Yii::$app->user->id;
            $notification->to_user = $model->user_id;
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
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
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
     * Displays a single DocumentDetail model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if( Yii::$app->request->isPost ){
            $params = Yii::$app->request->post('DocumentDetail');

            $model = DocumentDetail::find()->andWhere(['id' => $params['id']])->one();
            $userDetail = UserDetail::find()->andWhere(['user_id' => $model->user_id])->one();

            $model->status = $params['status'] == 1 ? 10 : 0;
            $verification = $params['status'] == 1 ? 'approved' : 'not approved';

            if (!$model->save()) {
                Yii::$app->session->setFlash('kv-detail-error', 'Updation Failed');
            }

            // Put a notification

            $message = '<b>' . $model->name . '</b> has been ' . $verification . ' by <b>Admin</b>. Please review and proceed';

            $notification = new Notification();
            $notification->from_user = Yii::$app->user->id;
            $notification->to_user = $model->user_id;
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
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
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

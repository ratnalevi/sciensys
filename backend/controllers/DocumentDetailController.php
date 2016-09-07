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

    /**
     * Lists all DocumentDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new DocumentDetail();
        $searchModel = new DocumentDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->post('hasEditable')) {
            $documentId = Yii::$app->request->post('editableKey');
            $model = DocumentDetail::find()->andWhere(['id' => $documentId])->one();
            $userDetail = UserDetail::find()->andWhere(['user_id' => $model->user_id])->one();

            $doc = current($_POST['DocumentDetail']);

            $model->status = $doc['status'];

            if (!$model->save()) {
                Yii::$app->session->setFlash('kv-detail-error', 'Updation Failed');
            }

            $verification = $model->status / 10 == 1 ? 'approved' : 'not approved';
            $message = '<b>' . $model->docType->name . '</b> report has been ' . $verification . ' by <b>Admin</b>. Please review and proceed';

            if( $userDetail !== null && $userDetail->mobile !== '' ) {
                FileHelper::sendSMS($userDetail->mobile, $message );
            }

            $notification = new Notification();
            $notification->from_user = Yii::$app->user->id;
            $notification->to_user = $model->user_id;
            $notification->message = $message;
            $notification->document_id = $model->id;
            $notification->is_read = Notification::UNREAD;
            $notification->created_at = time();
            $notification->read_at = 0;

            // send a message to user who uploaded the document

            if( !$notification->save() ){
                Yii::$app->session->setFlash('kv-detail-error', 'Updated successfully, but notification failed');
            }

            $output = '';
            if (isset( $doc['status'])) {
                $output = $doc['status'];
            }

            $out = Json::encode(['output'=>$output, 'message'=>'']);

            echo $out;
            return;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
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
     * @return mixed
     */
    public function actionView($id)
    {
        $model = new DocumentDetail();
        $searchModel = new DocumentDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->post('hasEditable')) {
            $documentId = Yii::$app->request->post('editableKey');
            $model = DocumentDetail::find()->andWhere(['id' => $documentId])->one();

            $doc = current($_POST['DocumentDetail']);

            $model->status = $doc['status'];

            $model->save();
            $output = '';
            if (isset( $doc['status'])) {
                $output = $doc['status'];
            }

            $out = Json::encode(['output'=>$output, 'message'=>'']);

            echo $out;
            return;
        }

        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
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

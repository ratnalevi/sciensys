<?php

namespace frontend\controllers;

use common\helpers\FileHelper;
use common\models\BusinessDetail;
use common\models\DocumentType;
use kartik\mpdf\Pdf;
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

    /**
     * Lists all DocumentDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentDetailSearch();

        if( Yii::$app->request->isPost ){
            $params = Yii::$app->request->post('DocumentDetail');
            $model = DocumentDetail::find()
                ->andWhere(['doc_type_id' => $params['doc_type_id']])
                ->andWhere(['user_id' => Yii::$app->user->id ])
                ->one();

            if( $model === null ){
                $model = new DocumentDetail();
                $model->created_at = time();
            }

            if( isset( $params['file'] ) ){
                $model->doc_type_id = $params['doc_type_id'];
                if (( $model->submit()) !== null && !$model->hasErrors()) {

                    $userDetail = UserDetail::find()->andWhere(['user_id' => $model->user_id])->one();

                    $message = '<b>' . $model->docType->name . '</b> has been uploaded by ' . $userDetail->getFullName() . " Review required";

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

                    $docs = DocumentType::find()->indexBy('id')->all();

                    if( $userDetail !== null && $userDetail->mobile !== '' ) {
                        $message = 'Dear ' . $userDetail->getFullName() . ", " . $docs[$params['doc_type_id']]->name . ' document has been uploaded successfully. We will update on approval';
                        FileHelper::sendSMS($userDetail->mobile, $message );
                    }

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
        }else{
            $model = new DocumentDetail();
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $business = BusinessDetail::find()->andWhere(['user_id' => $id])->one();
        $personal = UserDetail::find()->andWhere(['user_id' => $id ] )->one();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'business' => $business,
            'personal' => $personal
        ]);
    }

    public function actionGetReport(){

        $id = Yii::$app->user->id;
        $business = BusinessDetail::find()->andWhere(['user_id' => $id])->one();
        $personal = UserDetail::find()->andWhere(['user_id' => $id ] )->one();

        $path = Yii::$app->basePath;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $this->renderPartial('_final_document', [
                'personal' => $personal,
                'business' => $business
            ]),
            'cssFile' => $path.  '/web/css/other.css',
            'destination' => Pdf::DEST_BROWSER,
            'options' => [
                'title' => 'Business Acceptance',
                'subject' => 'Final acceptance report generated after verifying the business details'
            ],
            'methods' => [
                'SetHeader' => ['Generated By: Sciensys || Generated On: ' . date("r")],
                'SetFooter' => ['|Page {PAGENO}|'],
            ]
        ]);
        return $pdf->render();

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

<?php

namespace frontend\controllers;

use common\helpers\FileHelper;
use common\models\DocumentType;
use frontend\models\DocumentDetailForm;
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
        $model = new DocumentDetailForm();

        if( $model->load( Yii::$app->request->post()) ){

            if (( $doc = $model->submit() ) instanceof DocumentDetail && !$doc->hasErrors()) {

                $userDetail = UserDetail::find()->andWhere(['user_id' => $doc->user_id])->one();

                $message = '<b>' . $doc->docType->name . '</b> report has been uploaded by ' . $userDetail->fullName . " Review required";

                $admin = User::find()->andWhere(['type' => User::ROOT_USER ])->one();

                $notification = new Notification();
                $notification->from_user = Yii::$app->user->id;
                $notification->to_user = $admin->id;
                $notification->message = $message;
                $notification->document_id = $doc->id;
                $notification->is_read = Notification::UNREAD;
                $notification->created_at = time();
                $notification->read_at = 0;

                // send a message to user who uploaded the document

                $docs = DocumentType::find()->indexBy('id')->all();

                if( $userDetail !== null && $userDetail->mobile !== '' ) {
                    $message = 'Dear ' . $userDetail->fullName . ", " . $docs[$doc->doc_type_id]->name . ' document has been uploaded successfully. We will update on approval';
                    FileHelper::sendSMS($userDetail->mobile, $message );
                }

                if( !$notification->save() ){
                    Yii::$app->session->setFlash('kv-detail-error', 'Updated successfully, but notification failed');
                }

                Yii::$app->getSession()->setFlash('success', 'Saved successfully');
            }
        }

        $id = Yii::$app->user->id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $personal = UserDetail::find()->andWhere(['user_id' => $id ] )->one();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'personal' => $personal
        ]);
    }

    public function actionGetReport(){

        $id = Yii::$app->user->id;
        $personal = UserDetail::find()->andWhere(['user_id' => $id ] )->one();

        $path = Yii::$app->basePath;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $this->renderPartial('_final_document', [
                'personal' => $personal,
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

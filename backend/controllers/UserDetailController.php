<?php

namespace backend\controllers;

use backend\models\DocumentDetailSearch;
use common\helpers\FileHelper;
use common\models\DocumentDetail;
use common\models\Notification;
use Yii;
use common\models\UserDetail;
use backend\models\UserDetailSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\User;

/**
 * UserDetailController implements the CRUD actions for UserDetail model.
 */
class UserDetailController extends Controller
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
     * Lists all UserDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserDetail model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $userDetails = UserDetail::find()->andWhere(['id' => $id ])->one();
        $searchModel = new DocumentDetailSearch();
        $searchModel->user_id = $userDetails->user_id ;
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
            $message = $model->docType->name . ' document has been ' . $verification . ' by Admin. Please review and proceed';

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

        return $this->render('view', [
            'user' => $this->findModel($id),
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new UserDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserDetail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserDetail model.
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
     * Finds the UserDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

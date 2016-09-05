<?php

namespace frontend\controllers;

use Yii;
use common\models\UserDetail;
use frontend\models\UserDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
     * Displays active / logged in UserDetail model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewMe()
    {
        $id = Yii::$app->user->identity->id;
        return $this->render('view', [
            'model' => $this->findModel($id),
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

        $model->user_id = Yii::$app->user->id;

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
    public function actionUpdate($id = 0 )
    {
        if( $id == 0 ){
            $model = new UserDetail();
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-me']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateMe()
    {
        $id = Yii::$app->user->id;

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-me']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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
            if (($model = UserDetail::findByUserId($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
    }
}

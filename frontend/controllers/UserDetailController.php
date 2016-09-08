<?php

namespace frontend\controllers;

use Yii;
use common\models\UserDetail;
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

        $model = $this->findModel($id);

        if($model === null || $id == 0 ){
            $model = new UserDetail();
            return $this->render('create', [
                'model' => $model,
            ]);
        }

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
            return $this->redirect(['view-me']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateMe()
    {
        $id = Yii::$app->user->id;

        $model = $this->findModel($id);

        if($model === null || $id == 0 ){
            $model = new UserDetail();
            return $this->render('create', [
                'model' => $model,
            ]);
        }

        if ($model->load(Yii::$app->request->post()) ){
            if( $model->save()) {
                return $this->redirect(['view-me']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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
                return null;
            }
        }
    }
}

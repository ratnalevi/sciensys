<?php

namespace frontend\controllers;

use Yii;
use common\models\BusinessDetail;
use frontend\models\BusinessDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BusinessDetailController implements the CRUD actions for BusinessDetail model.
 */
class BusinessDetailController extends Controller
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
     * Displays a single BusinessDetail model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewMe()
    {
        $id = Yii::$app->user->identity->id;

        $model = $this->findModel($id);

        if($model === null ){
            $model = new BusinessDetail();
            return $this->render('create', [
                'model' => $model,
            ]);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new BusinessDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BusinessDetail();

        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) ) {
            if ($model->save()) {
                return $this->redirect(['view-me']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdateMe( )
    {
        $id = Yii::$app->user->id;

        $model = $this->findModel($id);

        if($model === null || $id == 0 ){
            $model = new BusinessDetail();
            return $this->render('create', [
                'model' => $model,
            ]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-me']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the BusinessDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BusinessDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BusinessDetail::findOne($id)) !== null) {
            return $model;
        } else {
            if (($model = BusinessDetail::findByUserId($id)) !== null) {
                return $model;
            } else {
                return null;
            }
        }
    }
}

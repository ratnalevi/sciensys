<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use common\models\Notification;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'get-notifications', 'update-notifications'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm(['scenario' => 'backend']);
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $cookies = Yii::$app->request->cookies;
            if ( $cookies->has('userId') ){
                $cookies->remove('userId');
            }

            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => 'userId',
                'value' => Yii::$app->user->id,
                'httpOnly' => false
            ]));
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Returns notifications for the user if any
     * @param $userId
     * @return Notification
     */

    public function actionGetNotifications( $userId ){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $notifications = Notification::find()->andWhere(['to_user' => $userId ])->andWhere(['is_read' => 0])->limit(15)->orderBy(['created_at' => SORT_DESC ])->all();
        return ArrayHelper::toArray($notifications);
    }

    /**
     * Updates read notifications for the user if any
     * @param $userId
     * @param $lastSeen
     * @return bool
     */

    public function actionUpdateNotifications( $userId, $lastSeen ){
        Yii::$app->response->format = Response::FORMAT_JSON;
        Notification::updateAll([ 'is_read' => 1, 'read_at' => time() ], 'created_at <= :lastSeen AND to_user = :id' , [':lastSeen' => $lastSeen , ':id' => $userId ]);
        return true;
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}

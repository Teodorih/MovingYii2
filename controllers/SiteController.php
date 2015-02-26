<?php

namespace app\controllers;


use Yii;
use app\models\LoginForm;;
use app\models\SignupForm;
use app\models\Square;
use app\models\ContactForm;
use app\models\User;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\View;
use yii\web\YiiAsset;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $ownSquare = new Square();
        if (!Yii::$app->user->isGuest)
        {
            $arraySquares = Square::getCurrentSquares()->all();
            $triggerName = "app.start.interval";
            $this->view->registerJs("$(document).ready(function(){
                $(document).trigger('$triggerName');
                });" ,View::POS_HEAD, 'interval');
            $this->view->registerJs("user_id=".json_encode(Yii::$app->user->id),View::POS_END, 'own_id');

        }
        else
        {
            $arraySquares = null;

        }
        return $this->render('index',array('arraySquares'=>$arraySquares));
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        $this->view->registerJs("user_id=null",View::POS_END, 'own_id');
        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    $newOwnSquare = new Square();
                    $newOwnSquare->save();
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    public function actionDragbase()
    {
        if(Yii::$app->request->isPost)
        {
            $square = new Square(Yii::$app->user->id,0,0);
            $square->setAttributes($_POST['square'], false);
            if(!$square->save())
            {
                echo $square->getErrors();
            }

        }
    }
    public function actionIntervalbase()
    {
        $arraySquares = Square::getCurrentSquares()->asArray()->all();
        if(!Yii::$app->user->isGuest) {
            echo json_encode($arraySquares);
        }
    }
    public function actionHistory()
    {
        $arrayUsers = User::find()->joinWith('square')->all();
        return $this->render('history',array('arrayUsers'=>$arrayUsers));
    }

}

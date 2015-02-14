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
            $ownSquare = $ownSquare->getOwnSquare(Yii::$app->user);
            $arraySquares = Square::getAllSquares();
            $this->view->registerJs("user_id=".json_encode(Yii::$app->user->id),View::POS_END, 'own_id');

        }
        else
        {
            $ownSquare = null;
            $arraySquares = null;

        }
        return $this->render('index',array('ownSquare'=>$ownSquare, 'arraySquares'=>$arraySquares));
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
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

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    $NewOwnSquare = new Square();
                    $NewOwnSquare->save();
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
            $square = Square::findByIdentity($_POST['ip']);
            $square->changeOwnSquare();
            $square->save();
        }
    }
    public function actionIntervalbase()
    {
        $arraySquares = Square::getAllSquaresToString();
        echo json_encode($arraySquares);
    }
    public function actionHistory()
    {
        $arrayUsers = User::getAllFromUsersAndSquares();
        return $this->render('history',array('arrayUsers'=>$arrayUsers));
    }

}

<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\ModUsuariosEntUsuarios;
use app\models\UserLoginForm;
use app\dgomUtils\Calendario;
use app\dgomUtils\mail\DGomMailer;
use app\dgomUtils\setup\SetupUtils;





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
                    'logout' => ['post', 'get'],
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
        if (Yii::$app->user->isGuest) {
            if (isset($_SERVER['REQUEST_URI'])) {
                return $this->redirect(array('site/login', 'pending_url' => $_SERVER['REQUEST_URI']));
            }
            return $this->redirect("site/login");
        }
        return $this->render('index');
    }

    public function actionLogin($pending_url = null)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new UserLoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (isset($pending_url) && !empty($pending_url)) {
                return $this->redirect($pending_url);
            }
            return $this->goHome();
        }

        $model->txt_password = '';

        $this->layout = "login";

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignUp()
    {

        if(SetupUtils::getString(SetupUtils::SISTEMA_SINGUP_TYPE) == 1){
            $model = new ModUsuariosEntUsuarios([
                'scenario' => ModUsuariosEntUsuarios::SCENARIO_CREATE
            ]);
        }else if(SetupUtils::getString(SetupUtils::SISTEMA_SINGUP_TYPE) == 2){
            $model = new ModUsuariosEntUsuarios([
                'scenario' => ModUsuariosEntUsuarios::SCENARIO_CREATE_CODE
            ]);            
        }else if(SetupUtils::getString(SetupUtils::SISTEMA_SINGUP_TYPE) == 3){
            $model = new ModUsuariosEntUsuarios([
                'scenario' => ModUsuariosEntUsuarios::SCENARIO_CREATE_CONTEST
            ]);  
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $user = $model->signup()) {
            if (Yii::$app->getUser()->login($user)) {
                if(SetupUtils::getString(SetupUtils::SISTEMA_SINGUP_TYPE) == 2){
                    if ($model->codigo != "demo") {
                        $codigo = CatCodigos::find()->where([
                            'txt_nombre' => $model->codigo
                        ])->one();

                        $codigo->b_usado = 1;
                        $codigo->save();

                        $usuarioCodigo = new RelUsuariosCodigos();
                        $usuarioCodigo->id_codigo = $codigo->id_codigo;
                        $usuarioCodigo->id_usuario = $user->id_usuario;
                        $usuarioCodigo->save();
                    }
                }
                $sendWelcomeEmail = SetupUtils::getBoolean(SetupUtils::MAIL_WELCOME_EMAIL);

                if ($sendWelcomeEmail) {
                    $dgomMailer = new DGomMailer();
                    //$parametrosEmail['url'] = Yii::$app->urlManager->createAbsoluteUrl(['ingresar/' . $user->txt_token]);
                    $parametrosEmail['url'] = Yii::$app->urlManager->createAbsoluteUrl('site/dashboard');
                    $parametrosEmail['user'] = $user->getNombreCompleto();
                    $parametrosEmail['email'] = $user->txt_email;
                    $parametrosEmail['pass'] = $model->txt_password;
                    $dgomMailer->sendEmailBienvenida($model->txt_email, $parametrosEmail);
                }
                return $this->goHome();
            }
        }

        $this->layout = "blank";
        return $this->render('sign-up', [
            'model' => $model
        ]);
    }

    public function actionRecuperarPassword()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new UserLoginForm();
        $model->load(Yii::$app->request->post());

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }


        if ($model->load(Yii::$app->request->post())) {
            $model = ModUsuariosEntUsuarios::findByEmail($model->txt_email);
            if (isset($model)) {

                $model->txt_change_password_token = uniqid("chan_");
                $model->fch_change_password_token_time = Calendario::getFechaActualTimeStamp();
                $model->save(false);

                $url = Url::base(true) . '/usuarios/cambiar-password?token=' . $model->txt_change_password_token . '&email=' . $model->txt_email;
                $mailer = new DGomMailer();
                $mailer->sendEmailRecuperarPassword($model->txt_email, [
                    "nombre" => $model->nombreCompleto,
                    'url' => $url,
                    'url_base' =>  Url::base(true)
                ]);
            } else {
                $model = new UserLoginForm();
            }

            Yii::$app->session->setFlash('success', "Se ha enviado un correo con los datos para recuperar la contraseña.");
        }

        $model->txt_password = '';
        $this->layout = 'login';
        return $this->render('recover_password', [
            'model' => $model,
        ]);
    }
}

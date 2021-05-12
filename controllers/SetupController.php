<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\setup\Setup;
use app\models\setup\CatComponentes;
use app\models\setup\EntConfiguraciones;
use app\components\AccessControlExtend;
use app\dgomUtils\mail\DGomMailer;
use app\dgomUtils\setup\SetupUtils;

class SetupController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControlExtend::className(),
                'only' => [
                    'logout',
                    'index',
                    'componente'

                ],
                'rules' => [
                    [
                        'actions' => [
                            'logout',
                            'index',
                            'componente'

                        ],
                        'allow' => true,
                        'roles' => ['root', '@'],
                    ],
                ],

            ],
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
        ];
    }

    public function actionIndex()
    {
        $setup = new Setup();
        $setup->checkConfiguracionComponentes();

        return $this->goHome();
    }




    public function actionSiteConfig($uudi = null)
    {

        if (!$uudi) {
            $uudi = "Mail";
        }

        $componente = CatComponentes::getComponenteByName($uudi);
        $configuraciones = $componente->entConfiguraciones;

        $componentes = CatComponentes::find()
            ->where(['b_habilitado'=> 1])
            ->orderBy("txt_componente")
            ->all();

        return $this->render("componente", ["componente" => $componente, "configuraciones" => $configuraciones, "componentes" => $componentes]);
    }



    public function actionUpdate($uudi)
    {

        $configuracion = EntConfiguraciones::getConfiguracionById($uudi);

        if ($configuracion->load(Yii::$app->request->post())) {
            if (!$configuracion->save()) {
                throw new HttpException(500, "No se pudo guardar el objeto");
            } else {

                switch ($configuracion->uuid) {
                    case SetupUtils::MAIL_TO_TEST:
                        $this->testSendMail();
                        break;
                }
            }
        } else {
            throw new HttpException(500, "No se pudo cargar el objeto");
        }
    }


    private function testSendMail()
    {
        $mailer = new DGomMailer();

        $templateHtml = "<h1>Correo de prueba</h1><p>Este es un mail de prueba para verificar que la plataforma se encuentra correctamente configurada</p>";
        $templateText = "Correo de prueba para validar que el correo esta correctamente configurado";
        $from = SetupUtils::getString(SetupUtils::MAIL_USER_NAME);
        $to = SetupUtils::getString(SetupUtils::MAIL_TO_TEST);
        $subject = "Mail de verificación de configuración";
        $params = [];

        $mailer->sendBasicEmail($templateHtml, $templateText, $from, $to, $subject, $params);
    }
}

<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ModUsuariosEntUsuarios;
use app\models\ModUsuariosEntUsuariosSearch;
use app\models\ModUsuariosCatStatusUsuarios;
use app\models\ModUsuariosCatRoles;
use app\models\UserLoginForm;
use app\dgomUtils\Calendario;

/**
 * UsuariosController implements the CRUD actions for ModUsuariosEntUsuarios model.
 */
class UsuariosController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all ModUsuariosEntUsuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ModUsuariosEntUsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ModUsuariosEntUsuarios model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('detail', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ModUsuariosEntUsuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ModUsuariosEntUsuarios();
        $model->scenario = ModUsuariosEntUsuarios::SCENARIO_CREATE;


        $model->txt_token = uniqid("usr_");
        $model->txt_auth_key = uniqid("autk_");
        $model->txt_password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->txt_password);
        $model->fch_creacion = Calendario::getFechaActualTimeStamp();
        $model->fch_actualizacion = $model->fch_creacion;

        $statusUsuarioList = ModUsuariosCatStatusUsuarios::getHabilitados();
        $rolesUsuarioList = ModUsuariosCatRoles::getHabilitados();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_usuario]);
        }

        return $this->render('create', [
            'model' => $model,
            'statusUsuarioList' => $statusUsuarioList,
            'rolesUsuarioList' => $rolesUsuarioList
        ]);
    }

    /**
     * Updates an existing ModUsuariosEntUsuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $statusUsuarioList = ModUsuariosCatStatusUsuarios::getHabilitados();
        $rolesUsuarioList = ModUsuariosCatRoles::getHabilitados();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_usuario]);
        }

        return $this->render('update', [
            'model' => $model,
            'statusUsuarioList' => $statusUsuarioList,
            'rolesUsuarioList' => $rolesUsuarioList
        ]);
    }

    /**
     * Deletes an existing ModUsuariosEntUsuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCambiarPassword($token = null, $email = null)
    {

        if ($token == null or $token == "") {
            Yii::$app->session->setFlash('warning', "Token incorrecto.");
            return $this->redirect(['site/login']);
        }

        $model = ModUsuariosEntUsuarios::getByChangeToken($token);
        if ($model == null) {
            Yii::$app->session->setFlash('warning', "Token incorrecto.");
            return $this->redirect(['site/login']);
        }

        $model->txt_password = '';
        $model->scenario = ModUsuariosEntUsuarios::SCENARIO_RECOVER;

        $model->txt_change_password_token = null;
        $model->fch_change_password_token_time = null;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //Yii::$app->session->setFlash('success', "Se ha actualizado la contraseña correctamente.");

            $model_login = new UserLoginForm();

            $model_login->txt_email = $email;
            $model_login->txt_password = $model->repeatPassword;

            $model_login->login();

            return $this->redirect(['site/index', 'change_pwd' => true]);
        }
        $this->layout = 'blank';
        return $this->render('change_password', ['model' => $model]);
    }



    //--------------- UTILIDADES --------------------------
    /**
     * Finds the ModUsuariosEntUsuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ModUsuariosEntUsuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ModUsuariosEntUsuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use app\models\CatCodigos;
use app\dgomUtils\Calendario;

/**
 * This is the model class for table "mod_usuarios_ent_usuarios".
 *
 * @property int $id_usuario
 * @property string $txt_token
 * @property string $txt_imagen
 * @property string $txt_username
 * @property string $txt_apellido_paterno
 * @property string $txt_apellido_materno
 * @property string $txt_auth_key
 * @property string $txt_password_hash
 * @property string $txt_password_reset_token
 * @property string $txt_email
 * @property string $txt_password
 * @property string $fch_creacion
 * @property string $fch_actualizacion
 * @property int $id_status
 * @property int $b_remember_me
 * @property int $id_rol_usuario
 * @property string $txt_change_password_token
 * @property string $fch_change_password_token_time
 *
 * @property ModUsuariosCatStatusUsuarios $status
 * @property ModUsuariosCatRoles $rolUsuario
 */
class ModUsuariosEntUsuarios extends \yii\db\ActiveRecord implements IdentityInterface
{


    const SCENARIO_CREATE = 'create';
    const SCENARIO_CREATE_CODE = 'create_code';
    const SCENARIO_CREATE_CONTEST = 'create_contest';
    const SCENARIO_RECOVER = 'recover';

    public $repeatEmail;
    public $repeatPassword;
    public $aceptarTerminos;
    public $codigo;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mod_usuarios_ent_usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['txt_username'], 'required', 'message' => "Debe especificar un nombre"],
            [['txt_apellido_paterno', 'txt_apellido_materno'], 'required', 'message' => "Debe especificar un apellido", 'except' => self::SCENARIO_RECOVER],
            [['txt_email'], 'required', 'message' => "Debe especificar un correo electrónico "],
            [['txt_email'], 'email', 'message' => 'Necesita ingresar un email con formato válido'],
            [['txt_email'], 'unique', 'message' => "Este correo ya se encuentra registrado"],
            [['txt_email', 'repeatEmail'], 'trim'],
            [['txt_password'], 'required', 'message' => "Debe ingresar una contraseña"],
            [['txt_auth_key', 'txt_password_hash', 'id_status'], 'required', 'message' => "Campos faltantes"],
            [['fch_creacion', 'fch_actualizacion', 'fch_change_password_token_time'], 'safe'],
            [['id_status', 'b_remember_me'], 'integer'],
            [['txt_username', 'txt_apellido_paterno', 'txt_apellido_materno'], 'string', 'max' => 30],
            [['txt_token'], 'string', 'max' => 100],
            [['txt_imagen'], 'string', 'max' => 200],
            [['txt_password_hash', 'txt_password_reset_token', 'txt_email'], 'string', 'max' => 255],
            [['txt_auth_key'], 'string', 'max' => 32],
            [['txt_password'], 'string', 'max' => 20],
            [['txt_token'], 'unique'],
            [['txt_change_password_token'], 'string', 'max' => 45],
            [['txt_password_reset_token'], 'unique'],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => ModUsuariosCatStatusUsuarios::className(), 'targetAttribute' => ['id_status' => 'id_status']],
            ['repeatEmail', 'required', 'on' => self::SCENARIO_CREATE, 'message' => "Debe reingresar el correo anterior"],
            ['repeatEmail', 'compare', 'compareAttribute' => 'txt_email', 'message' => "Los correos no coinciden"],
            ['repeatPassword', 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_RECOVER], 'message' => "Debe reingresar la misma contraseña"],
            ['repeatPassword', 'compare', 'compareAttribute' => 'txt_password', 'message' => "Las contraseñas no coinciden"],
            
            [['id_rol_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => ModUsuariosCatRoles::className(), 'targetAttribute' => ['id_rol_usuario' => 'id_usuario_rol']],

            //En caso de requerir validar un código de acceso se habilita la siguiente linea
            //['codigo','validarCodigo'],
            //['codigo', 'required', 'on' => self::SCENARIO_CREATE_CODE, 'message' => "Debe proporcionar el código de activación proporcionado"],

            //En caso de necesitar aceptar TyC se habilita la siguiente línea
            //['aceptarTerminos', 'required', 'on' => self::SCENARIO_CREATE, 'message' => "Debe aceptar el presente aviso"],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'id_rol_usuario' => 'Rol del usuario',
            'txt_token' => 'Txt Token',
            'txt_imagen' => 'Txt Imagen',
            'txt_username' => 'Nombre',
            'txt_apellido_paterno' => 'Apellido paterno',
            'txt_apellido_materno' => 'Apellido materno',
            'txt_auth_key' => 'Txt Auth Key',
            'txt_password_hash' => 'Txt Password Hash',
            'txt_password_reset_token' => 'Txt Password Reset Token',
            'txt_email' => 'Correo electrónico',
            'txt_password' => 'Contraseña',
            'fch_creacion' => 'Fecha de creación',
            'fch_actualizacion' => 'Fch Actualizacion',
            'id_status' => 'Estatus',
            'b_remember_me' => 'B Remember Me',
            'txt_change_password_token' => 'Txt Change Password Token',
            'fch_change_password_token_time' => 'Fch Change Password Token Time',
            'repeatPassword' => 'Confirmar contraseña',
            'repeatEmail' => 'Confirmar correo',
            'codigo' => 'Código de activación',
            'aceptarTerminos'=> 'Acepto que conozco el contenido del presente Aviso de Privacidad y estoy de acuerdo con el tratamiento de los datos personales en los términos expresados en dicho Aviso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(ModUsuariosCatStatusUsuarios::className(), ['id_status' => 'id_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolUsuario()
    {
        return $this->hasOne(ModUsuariosCatRoles::className(), ['id_usuario_rol' => 'id_rol_usuario']);
    }



    //---------------------- CUSTOM METHODS ------------------

    public static function findByEmail($email)
    {
        $res = self::find()->where(['txt_email' => $email])->one();
        return $res;
    }

    public function getNombreCompleto()
    {
        return $this->txt_username . " " . $this->txt_apellido_paterno . " " . $this->txt_apellido_materno;
    }


    public static function getByChangeToken($token)
    {
        return self::find()->where(['txt_change_password_token' => $token])->one();
    }

    //------------ implements IdentityInterface ----------------------

    public static function findIdentity($id)
    {
        $dbUser = self::find()
            ->where([
                "id_usuario" => $id
            ])
            ->one();

        if ($dbUser==null) {
            return null;
        }
        return new static($dbUser);
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        $dbUser = self::find()
            ->where(["txt_token" => $token])
            ->one();

        if (!count($dbUser)) {
            return null;
        }
        return new static($dbUser);;
    }

    public static function findByUsername($username)
    {
        $dbUser = self::find()
            ->where([
                "txt_username" => $username
            ])
            ->one();

        if (!count($dbUser)) {
            return null;
        }
        return new static($dbUser);
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }


    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


    public function validatePassword($password)
    {
        if ($this->_user != null) {
            $res = $this->txt_password == $this->_user->txt_password;
            return $res;
        }
        return false;
    }

    public function getId()
    {
        return $this->id_usuario;
    }


    public function loadUser()
    {
        $dbUser = self::findByEmail($this->txt_email);
        return $dbUser;
    }




    // Custom AEC  Methods

    public function signUp()
    {

        $passwordHash = Yii::$app->getSecurity()->generatePasswordHash($this->txt_password);

        $this->id_status = 2;
        $this->txt_auth_key = "authKey";
        $this->txt_password_hash = $passwordHash;
        $this->txt_token = uniqid('usr_');
        $this->fch_creacion = Calendario::getFechaActualTimeStamp();

        if ($this->save()) {
            return $this;
        } else {
            return null;
        }
    }


    /*
    Funcion para validar codigos tipo springer
    public function validarCodigo($attribute, $params)
    {

        if ($this->codigo == "demo") {
            return;
        }

        $codigoIngresado = CatCodigos::find()->where(["txt_nombre" => $this->codigo])->one();
        if (!$codigoIngresado) {
            $this->addError("codigo", "El código ingresado no existe");
            return;
        }

        if ($codigoIngresado->b_usado) {
            $this->addError("codigo", "Este código ya ha sido utilizado");
            return;
        }
    }
    */

    function getNombre(){
        return $this->txt_username . ' ' . $this->txt_apellido_paterno;
    }
}

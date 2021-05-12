<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use app\models\ModUsuariosEntUsuarios;
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
class ModUsuariosEntUsuariosExt extends ModUsuariosEntUsuarios implements IdentityInterface
{

    
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

        if (!count($dbUser)) {
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
}

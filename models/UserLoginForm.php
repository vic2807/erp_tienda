<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use app\models\ModUsuariosEntUsuarios as DbUser;

class UserLoginForm extends DbUser implements IdentityInterface
{

   
    public $_user = false;
    public $rememberMe;
   

    public static function tableName()
    {
        return 'mod_usuarios_ent_usuarios';
    }

    public function rules()
    {
        return [
            ['txt_email', 'trim'],
            ['txt_email', 'required', 'message' => 'Debe introducir su correo registrado'],
            ['txt_password', 'required', 'message' => 'Debe introducir una contraseña'],
            ['txt_password', 'validatePassword', 'message' => 'Contraseña incorrecta'],
            ['txt_email', 'email']
            
        ];
    }

    public function login() {
        $this->loadUser();
        $valid = $this->validate();
		if ($valid && $this->validatePassword($this->txt_password)) {
            
            if($this->_user == null){
                $this->addError('txt_email', "Usuario no encontrado en el sistema"); //TODO 20190910 AEC este codigo no se esta ejecutando habra que revisar que sicede para si es necesario que se diga si el usuario existe o no
                return false;
            }
			return Yii::$app->user->login ( $this->_user, $this->rememberMe ? 3600 * 24 * 30 : 0 );
        }
        $this->addError('txt_password', "Usuario y/o contraseña incorrectos.");
		return false;
    }

    public function loadUser() {
        $dbUser = null;
		if ($this->_user === false) {
            $dbUser = DbUser::findByEmail ( $this->txt_email );
            if($dbUser != null){
                $this->_user  = $dbUser;
            }
        }
        
        return $dbUser;
    }
    
}

<?php

namespace app\models;

use Yii;
use app\models\UserLoginForm;

class UserLoginFormExt extends UserLoginForm
{

    public function login()
    {
        $this->loadUser();
        $valid = $this->validate();
        if ($valid && $this->validatePassword($this->txt_password)) {

            if ($this->_user == null) {
                $this->addError('txt_email', "Usuario no encontrado en el sistema");
                return false;
            }
            return Yii::$app->user->login($this->_user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        $this->addError('txt_password', "Usuario y/o contraseña incorrectos.");
        return false;
    }

    public function loadUser()
    {
        $dbUser = null;
        if ($this->_user === false) {
            $dbUser = DbUser::findByEmail($this->txt_email);
            if ($dbUser != null) {
                $this->_user  = $dbUser;
            }
        }

        return $dbUser;
    }
}

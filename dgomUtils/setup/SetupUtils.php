<?php

namespace app\dgomUtils\setup;

use app\models\setup\EntConfiguraciones;


class SetupUtils{


    //Login
    const LOGIN_USR_PASS            = 'LOGIN_USR_PASS';
    const LOGIN_ENABLE_REGISTER     = 'LOGIN_ENABLE_REGISTER';
     
    //Firebase
    const LOGIN_FIREBASE                = 'LOGIN_FIREBASE';
    const FIREBASE_JS_SCRIPT            = 'FIREBASE_JS_SCRIPT';
    const FIREBASE_API_KEY              = 'FIREBASE_API_KEY';
    const FIREBASE_AUTH_DOMAIN          = 'FIREBASE_AUTH_DOMAIN';
    const FIREBASE_DATABASE_URL         = 'FIREBASE_DATABASE_URL';
    const FIREBASE_PROJECT_ID           = 'FIREBASE_PROJECT_ID';
    const FIREBASE_STORAGE_BUCKET       = 'FIREBASE_STORAGE_BUCKET';
    const FIREBASE_MESSANGING_SENDER_ID = 'FIREBASE_MESSANGING_SENDER_ID';


    //Email
    const MAIL_HOST                     = 'MAIL_HOST';
    const MAIL_USER_NAME                = 'MAIL_USER_NAME';
    const MAIL_PASSWORD                 = 'MAIL_PASSWORD';
    const MAIL_PORT                     = 'MAIL_PORT';
    const MAIL_ENCRYPTION               = 'MAIL_ENCRYPTION';
    const MAIL_ENABLED                  = 'MAIL_ENABLED';
    const MAIL_TO_TEST                  = 'MAIL_TO_TEST';
    const MAIL_WELCOME_EMAIL            = 'MAIL_WELCOME_EMAIL';
    const MAIL_ACTIVATION_EMAIL         = 'MAIL_ACTIVATION_EMAIL'; 
    const MAIL_SEND_CCO                 = 'MAIL_SEND_CCO';

    //Sistema
    const SISTEMA_CORREO_CONTACTO       = 'SISTEMA_CORREO_CONTACTO';
    const SISTEMA_NOMBRE_EMPRESA        = 'SISTEMA_NOMBRE_EMPRESA';
    const SISTEMA_CACHE_TIME            = "SISTEMA_CACHE_TIME";
    const SISTEMA_CACHE_TIME_LARGE      = "SISTEMA_CACHE_TIME_LARGE";
    const SISTEMA_SINGUP_TYPE           = 'SISTEMA_SINGUP_TYPE';   


     //API
     const API_SECRET                    = 'API_SECRET';
     const API_KEY                       = 'API_KEY';
     const API_APP_VERSION_ANDROID       = 'API_APP_VERSION_ANDROID';
     const API_APP_VERSION_IOS           = 'API_APP_VERSION_IOS';


    /**
     * Obtiene un valor de true or false de una propuedad
     */
    public static function getBoolean($propertyName){
        $config = new EntConfiguraciones();

        $value = $config->find()->where(['uuid'=>$propertyName])->one();

        if($value){
            return $value->getPropertyByEnvironmentVal();
        }
        return null;
    }


    /**
     * Obtiene un valor de true or false de una propuedad
     */
    static function getString($propertyName){
        $config = new EntConfiguraciones();

        $value = $config->find()->where(['uuid'=>$propertyName])->one();

        if($value){
            return $value->getPropertyByEnvironmentVal();
        }
        return null;
    }

    static function getEnviroment(){
        $config = new EntConfiguraciones();
        return $config->getPropertyByEnvironment();
    }

}
?>
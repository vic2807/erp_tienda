<?php
namespace app\models\setup;

use Yii;
use app\models\setup\CatEnvironments;
use yii\helpers\Url;
use yii\web\HttpException;

class Setup{

    public static function getEnvironment(){
        if(getenv('ENVIRONMENT')){
            return strtolower(getenv('ENVIRONMENT'));
        }

        return "dev";
    }

    public static function checkConfiguracion(){

        $environment = CatEnvironments::getEnvironmentByUudi(self::getEnvironment());
        
        if(!$environment->b_configurado){
            Yii::$app->response->redirect(Url::to(['setup']));
            return;
        }

        self::checkMantenimiento();

    }

    public function checkConfiguracionComponentes(){
        $componentes = CatComponentes::getAllComponentes();

        foreach($componentes as $componente){
            if($configuracionEnabled = $componente->enabledProperty){
                if($configuracionEnabled->propertyByEnvironmentVal){
                    if(!$componente->isSetPropertyByEnvironment($componente)){
                        Yii::$app->response->redirect(Url::to(['setup/componente', "uudi"=>$componente->txt_componente]));
                        return;
                    }
                }
            }
        }

        $environment = CatEnvironments::getEnvironmentByUudi(self::getEnvironment());
        $environment->b_configurado = 1;
        if(!$environment->save()){
            throw new HttpException(500, "No se pudo guardar la información del ambiente");
        }

        Yii::$app->response->redirect(["site/index"]);
        
    }

    public static function checkMantenimiento(){
        $componenteSistema = CatComponentes::getComponenteByName("Sistema");

        if($configuracionEnabled = $componenteSistema->enabledProperty){
            if($configuracionEnabled->propertyByEnvironmentVal!=1){
                Yii::$app->response->redirect(Url::to(['site/mantenimiento']));
                return;
            }
        }
    }

    


}
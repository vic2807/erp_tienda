<?php

namespace app\models\setup;

use Yii;
use yii\web\HttpException;
use app\models\CatEnvironments;

/**
 * This is the model class for table "cat_environments".
 *
 * @property int $id_environments
 * @property string $uudi
 * @property string $txt_nombre
 * @property string $txt_decripcion
 * @property int $b_configurado
 */
class CatEnvironmentsExt extends CatEnvironments
{
    public static function getEnvironmentByUudi($uudi){
        $environment = self::find()->where(["uudi"=>$uudi])->one();

        if(!$environment){
            throw new HttpException(404, "No existe de ambiente '$uudi' configurado en Setup.php");
        }

        return $environment;
    }
}

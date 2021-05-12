<?php

namespace app\models\setup;

use Yii;
use yii\web\HttpException;

/**
 * This is the model class for table "cat_environments".
 *
 * @property int $id_environments
 * @property string $uudi
 * @property string $txt_nombre
 * @property string $txt_decripcion
 * @property int $b_configurado
 */
class CatEnvironments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_cat_environments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['b_configurado'], 'integer'],
            [['uudi', 'txt_nombre', 'txt_decripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_environments' => 'Id Environments',
            'uudi' => 'Uudi',
            'txt_nombre' => 'Txt Nombre',
            'txt_decripcion' => 'Txt Decripcion',
            'b_configurado' => 'B Configurado',
        ];
    }

    public static function getEnvironmentByUudi($uudi){
        $environment = self::find()->where(["uudi"=>$uudi])->one();

        if(!$environment){
            throw new HttpException(404, "No existe de ambiente '$uudi' configurado en Setup.php");
        }

        return $environment;
    }
}

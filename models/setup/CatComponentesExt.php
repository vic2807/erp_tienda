<?php

namespace app\models\setup;

use yii\helpers\Html;
use app\models\CatComponentes;


/**
 * This is the model class for table "cat_componentes".
 *
 * @property string $txt_componente
 * @property string $txt_descripcion
 *
 * @property EntConfiguraciones[] $entConfiguraciones
 */
class CatComponentesExt extends CatComponentes
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntConfiguraciones()
    {
        return $this->hasMany(EntConfiguraciones::className(), ['txt_componente' => 'txt_componente'])->andWhere(["!=", "txt_propiedad", "Enabled"]);
    }

    /**
     * Obtiene la configuracion de Enabled
     */
    public function getEnabledProperty(){
        return $this->hasOne(EntConfiguraciones::className(), ['txt_componente' => 'txt_componente'])->andWhere(["txt_propiedad"=>"Enabled"]);
    }

    public function getEstaHabilitado(){
        if($tienePropiedadEnable = $this->enabledProperty){
            if($tienePropiedadEnable->propertyByEnvironmentVal==1){
                return true;
            }else{
                return false;
            }
        }

        return true;
    }

    /**
     * Obtiene el elemento para modificar el Enabled
     */
    public function getElementoEnabled(){

        $property = $this->enabledProperty;

        if(!$property){
            return;
        }

        $form = Html::beginForm(['setup/update?uudi='.$property->id_configuracion], 'post');
        $form .= Html::activeRadioList($property, $property->propertyByEnvironment,["0"=>"Off", "1"=>"On"], [
            "item"=>function ($index, $label, $name, $checked, $value){
                return '<label class="switch ">
                        <input type="checkbox" name="'.$name.'" class="primary js-change-ajax js-check" value="'.$value.'" '.($checked?'checked':'').'>
                        <span class="slider round"></span>';
            }
        ]);
        $form .= Html::endForm();

        return $form;
    }


    /**
     * Obtiene un componente por su nombre
     */
    public static function getComponenteByName($componente){
        $componente = self::find()->where(["txt_componente"=>$componente])->one();

        if(!$componente){
            throw new HttpException(404, "No existe de componente '$componente' configurarlo en la base de datos.");
        }

        return $componente;
    }

    /**
     * Regresa el valor configurado para cada propiedad
     */
    public function isSetPropertyByEnvironment(){

        $configuraciones = $this->entConfiguraciones;

        foreach($configuraciones as $configuracion){
            switch (Setup::getEnvironment()) {
                case 'dev':
                    if(!$configuracion->txt_val_dev){
                        return false;
                    }
                    break;
                case 'qa':
                    if(!$configuracion->txt_val_qa){
                        return false;
                    }
                    break;
                case 'pro':
                    if(!$configuracion->txt_val_pro){
                        return false;
                    }
                    break;        
                
                default:
                    # code...
                    break;
            }
        }

        return true;

    }

    public static function getAllComponentes(){
        return self::find()->orderBy("txt_componente")->all();
    }

   
}

<?php

namespace app\models\setup;

use Yii;
use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveField;
use yii\web\HttpException;

/**
 * This is the model class for table "ent_configuraciones".
 *
 * @property int $id_configuracion
 * @property string $txt_componente
 * @property string $txt_propiedad
 * @property string $txt_descripcion
 * @property string $txt_val_dev
 * @property string $txt_val_qa
 * @property string $txt_val_pro
 * @property string $txt_tipo
 *
 * @property CatComponentes $txtComponente
 */
class EntConfiguraciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_ent_configuraciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['txt_componente'], 'required'],
            [['txt_descripcion'], 'string'],
            [['txt_componente', 'txt_propiedad'], 'string', 'max' => 100],
            [['txt_val_dev', 'txt_val_qa', 'txt_val_pro', 'txt_tipo'], 'string', 'max' => 40],
            [['uuid'], 'string', 'max' => 150],
            [['txt_componente'], 'exist', 'skipOnError' => true, 'targetClass' => CatComponentes::className(), 'targetAttribute' => ['txt_componente' => 'txt_componente']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_configuracion' => 'Id Configuracion',
            'txt_componente' => 'Txt Componente',
            'txt_propiedad' => 'Txt Propiedad',
            'txt_descripcion' => 'Txt Descripcion',
            'txt_val_dev' => 'Txt Val Dev',
            'txt_val_qa' => 'Txt Val Qa',
            'txt_val_pro' => 'Txt Val Pro',
            'txt_tipo' => 'Txt Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTxtComponente()
    {
        return $this->hasOne(CatComponentes::className(), ['txt_componente' => 'txt_componente']);
    }

    /**
     * REcupera el valor de la propiedad de acuerdo al ambiente configurado
     */
    public function getPropertyByEnvironmentVal(){
        switch (Setup::getEnvironment()) {
            case 'dev':
                return $this->txt_val_dev;
                break;
            case 'qa':
                return $this->txt_val_qa;
                break;
            case 'pro':
                return $this->txt_val_pro;
                break;        
            
            default:
                # code...
                break;
        }
    }

    /**
     * Recupera el tipo de ambiente configurado
     */
    public function getPropertyByEnvironment(){
        switch (Setup::getEnvironment()) {
            case 'dev':
                return "txt_val_dev";
                break;
            case 'qa':
                return "txt_val_qa";
                break;
            case 'pro':
                return "txt_val_pro";
                break;        
            
            default:
                # code...
                break;
        }
    }

    public function getPropertyByEnvironmentInput(ActiveForm $form){
        switch (Setup::getEnvironment()) {
            case 'dev':
                $field = $form->field($this, "txt_val_dev");
                $input = $this->getTypePropertyByenvironment($field);

                return $input;
                break;
            case 'qa':
                $field = $form->field($this, "txt_val_qa");
                $input = $this->getTypePropertyByenvironment($field);

                return $input;
                break;
            case 'pro':
                $field = $form->field($this, "txt_val_pro");
                $input = $this->getTypePropertyByenvironment($field);

                return $input;
                break;        
            
            default:
                # code...
                break;
        }
    }

    public function getTypePropertyByenvironment(ActiveField $field){
        switch ($this->txt_tipo) {
            case 'BOOLEAN':
                return $field->radioList(["0"=>"Off", "1"=>"ON"], [
                    "item"=>function ($index, $label, $name, $checked, $value){
                        return '<label class="switch ">
                                <input type="checkbox" name="'.$name.'" class="primary" value="'.$value.'" '.($checked?'checked':'').'>
                                <span class="slider round"></span>';
                    }])->label(false);
                break;
            
            default:
                return $field->textInput()->label(false);
                break;
        }
    }

    public static function getConfiguracionById($id){
        $configuracion = self::find()->where(["id_configuracion"=>$id])->one();

        if(!$configuracion){
            throw new HttpException(404, "No existe la configuracion solicitada");
        }

        return $configuracion;
    }
}

<?php

namespace app\models;

use Yii;
use app\dgomUtils\Calendario;
use yii\helpers\ArrayHelper;

/**
 * This class is the extended object from 2Gom
 * This is the model class for table "base_apps_backups".
 *
 * @property int $id_app_backup
 * @property string $uuid
 * @property string $fch_fecha_backup
 * @property int $b_database
 * @property string $create_usr
 * @property string $create_date
 * @property string|null $update_usr
 * @property string|null $update_date
 * @property int $b_habilitado
 */
class BaseAppsBackups extends BaseAppsBackupsBase
{

    public function attributeLabels()
    {
        return [
            'id_app_backup' => 'Id App Backup',
            'uuid' => 'Uuid',
            'fch_fecha_backup' => 'Fecha de Backup',
            'b_database' => 'Respaldo de base de datos',
            'create_usr' => 'Create Usr',
            'create_date' => 'Create Date',
            'update_usr' => 'Update Usr',
            'update_date' => 'Update Date',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * Método para recuperar el objeto por UUID
     */
    public static function getByUuid($uuid){
        $res = self::find()->where(['uuid'=>$uuid])->one();
        return $res;
    }

    /**
     * Método para recuperar el objeto por ID
     */
    public static function getById($id){
        $res = self::find()->where(['id'=>$id])->one();
        return $res;
    }


    /**
     * Método para recuperar la lista paginada
     */
    public static function getListPage($page = 1,$pageSize = 100){
        $offset = ($page -1) * $pageSize;

        $res = self::find()
        ->where(['b_habilitado'=>1])
        ->limit($pageSize)
        ->offset($offset)
        ->all();
        return $res;
    }

    /**
     * Método para recuperar la lista completa
     */
    public static function getListAll(){
        $res = self::find()
        ->where(['b_habilitado'=>1])
        ->orderBy('fch_fecha_backup DESC')
        ->all();
        return $res;
    }

    /**
     * Método que recupera un catalogo como ArrayHelper
     */
    public static function getArrayDropDown(){
        $res = ArrayHelper::map(BaseAppsBackups::find()->where(['b_habilitado'=>1])->orderBy('txt_nombre')->all(), 'id', 'txt_nombre');
        return $res;
    }

    /*
     * Metodo para asignar la informacion de creacion y update
     */
    public function beforeValidate(){
        $username = "guest";
        if(\Yii::$app->user->identity != null){
            $username = \Yii::$app->user->identity->txt_email;
        }
        if ($this->isNewRecord) {
            $date =  Calendario::getFechaActualTimeStamp();
            $this->create_usr = $username;
            $this->create_date = $date;
            $this->update_usr = $username;
            $this->update_date = $date;
        }
        else {
            $this->update_usr = $username;
            $this->update_date = Calendario::getFechaActualTimeStamp();
        }
        return parent::beforeValidate();
    }
}

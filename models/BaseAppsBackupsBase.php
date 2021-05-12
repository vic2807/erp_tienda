<?php

namespace app\models;

use Yii;

/**
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
class BaseAppsBackupsBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_apps_backups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'b_database', 'create_usr'], 'required'],
            [['fch_fecha_backup', 'create_date', 'update_date'], 'safe'],
            [['b_database', 'b_habilitado'], 'integer'],
            [['uuid', 'create_usr', 'update_usr'], 'string', 'max' => 45],
            [['uuid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_app_backup' => 'Id App Backup',
            'uuid' => 'Uuid',
            'fch_fecha_backup' => 'Fch Fecha Backup',
            'b_database' => 'B Database',
            'create_usr' => 'Create Usr',
            'create_date' => 'Create Date',
            'update_usr' => 'Update Usr',
            'update_date' => 'Update Date',
            'b_habilitado' => 'B Habilitado',
        ];
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mod_usuarios_cat_roles".
 *
 * @property int $id_usuario_rol
 * @property string $uuid
 * @property string $token
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property int $b_habilitado
 *
 * @property ModUsuariosEntUsuarios[] $modUsuariosEntUsuarios
 */
class ModUsuariosCatRoles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mod_usuarios_cat_roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'token', 'txt_nombre', 'txt_descripcion'], 'required'],
            [['b_habilitado'], 'integer'],
            [['uuid', 'txt_nombre'], 'string', 'max' => 45],
            [['token'], 'string', 'max' => 5],
            [['txt_descripcion'], 'string', 'max' => 250],
            [['uuid'], 'unique'],
            [['token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_usuario_rol' => 'Id Usuario Rol',
            'uuid' => 'Uuid',
            'token' => 'Token',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModUsuariosEntUsuarios()
    {
        return $this->hasMany(ModUsuariosEntUsuarios::className(), ['id_rol_usuario' => 'id_usuario_rol']);
    }

    //---------------------- CUSTOM ------------------------------

    public static function getHabilitados()
    {
        return self::find()
            ->where(['b_habilitado' => 1])
            //Quta el rol de super admin de la lista
            ->andWhere(['not in','token',['SADM']])
            ->all();
    }


}

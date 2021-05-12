<?php

namespace app\models;

use app\models\ModUsuariosCatStatusUsuarios;

class ModUsuariosCatStatusUsuariosExt extends ModUsuariosCatStatusUsuarios
{

    public static function getHabilitados()
    {
        return self::find()->where(['b_habilitado' => 1])->all();
    }
}

<?php

namespace app\models;

use  app\models\ModUsuariosCatRoles;


class ModUsuariosCatRolesExt extends ModUsuariosCatRoles
{
   public static function getHabilitados()
    {
        return self::find()->where(['b_habilitado' => 1])->all();
    }
}

<?php

namespace app\dgomUtils\menu;

use Yii;
use yii\helpers\Url;

class RulesMenu
{

    //Lista de roles del sistema, deben cuadrar con los de la tabla mod_usuarios_cat_roles
    const ROL_ANY         = "ANY";
    const ROL_GUEST       = "GUEST";
    const ROL_SUPER_ADMIN = "SADM";
    const ROL_ADMIN       = "ADM";
    const ROL_USUARIO     = "USR";
    const ROL_BACKUP      = "BACKUP";


    const menu = [

        // Dashboard PAGE 
        "Dashboard" => [
            "desc" => "Menu para el Dashboard",
            "icon" => "fas fa-home",
            "text" => "Dashboard",
            "url" => "site/index",
            "subItems" => [],
            "roles" => [self::ROL_ANY]
        ],

        //GESTION DE USUARIOS
        "Usuarios" => [
            "desc" => "Menu usuarios del sitema",
            "icon" => "fas fa-users",
            "text" => "Usuarios",
            "url" => "usuarios/index",
            "subItems" => [
                [
                    "text" => "Usuarios del sistema",
                    "url" => "usuarios/index",
                    "icon" => "fas fa-list",
                    'except-roles' => []
                ],

            ],
            "roles" => [self::ROL_ADMIN, self::ROL_SUPER_ADMIN]
        ],

        //SETUP DE LA HERRAMIENTA
        "Config" => [
            "desc" => "Configuracion",
            "icon" => "fas fa-cog",
            "text" => "Config",
            "url" => "setup/site-config",
            "subItems" => [],
            "roles" => [self::ROL_SUPER_ADMIN]
        ],

        //BACKUP DE LA HERRAMIENTA
        "Backup" => [
            "desc" => "Backup",
            "icon" => "fas fa-cog",
            "text" => "Backup",
            "url" => "backup/indexx",
            "subItems" => [
                [
                    "text" => "Backup del sistema",
                    "url" => "backup/index",
                    "icon" => "fas fa-list",
                    'except-roles' => []
                ]
            ],
            "roles" => [self::ROL_SUPER_ADMIN,self::ROL_BACKUP]
        ],
    ];


    //Permisos de contoladores
    const controladores = [
        
         "backup" => [  //--> Controlador
             "roles" => [self::ROL_BACKUP,self::ROL_SUPER_ADMIN], //--> roles con acceso al Controlador
             'except-action' => [ //--> Acciones específicas sin acceso
                 'actions'=>['index'], // --> Lista de acciones
                 'except-roles' => [] // --> Roles que no tendrán acceso a la accion dentro del controlador
             ]
        ],

    ];

    public static function hasAccess($reqController, $reqAction){
        
        $res = false;
        //Verifica el menu si no tiene acceso
        //$res = RulesMenu::hasMenuAccess($reqController, $reqAction);
        
        //Si no tiene acceso por el menú busca si tiene acceso por controlador
        if(!$res){
            $res = RulesMenu::hasControllerAccess($reqController, $reqAction);
        }

        return $res;
    }


    /**
     * Verifica si hay un permiso para acceder al controlador y la accion
     */
    private static function hasControllerAccess($reqController, $reqAction){

        if (Yii::$app->user->isGuest) {
            $rol = "GUEST";
        } else {
            $user = Yii::$app->user->identity;
            $rol = $user->rolUsuario->token;
        }

        foreach(self::controladores as $key => $item){
            //Si el rol del usuario no está en la lista de roles permitidos, avanza a la siguiente opcion
            if(!in_array($rol , $item['roles'])){
                continue;
            }

            //Si el controlador se encuenta en la lista, se tiene acceso, a menos que se definan acciones independientes
            if($key == $reqController){
                if(isset($item['except-action']) AND isset($item['except-action']['actions']) AND isset($item['except-action']['except-roles'])){
                    if(in_array($reqAction,$item['except-action']['actions']) AND in_array($rol,$item['except-action']['except-roles'])){
                        return false;
                    }
                }

                return true;
            }
        }

        return false;
    }

    private static function hasMenuAccess($reqController, $reqAction){
        if (Yii::$app->user->isGuest) {
            $rol = "GUEST";
        } else {
            $user = Yii::$app->user->identity;
            $rol = $user->rolUsuario->token;
        }

        $url = $reqController . "/" . $reqAction;

        foreach (self::menu as $item) {

            //Si el rol del usuario no está en la lista de roles permitidos, avanza al siguiente menu
            if(!in_array($rol , $item['roles'])){
                continue;
            }

            //Url principal
            if ($item['url'] == $url){
                    return true;
            }

            //Subitems del menu
            if(isset($item['subItems'])){
                foreach($item['subItems'] as $sub){
                    //Si la URL se encuentra en un subitem
                    if (isset($sub['url']) AND $sub['url'] == $url){
                        //Verifica que el rol no esté en la excepcion
                        if(!in_array($rol , $sub['except-roles' ])){
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }


    public static function getNavBar(){

        if (Yii::$app->user->isGuest) {
            $rol = "GUEST";
        } else {
            $user = Yii::$app->user->identity;
            $rol = $user->rolUsuario->token;
        }

        $str = "";
        foreach (self::menu as $item) {

            //Verifica si no esta el rol de ANY y del usuario
            if (!in_array(self::ROL_ANY, $item['roles']) and !in_array($rol, $item['roles'])) {
                continue;
            }
            if (count($item['subItems']) == 0) {
                $str .= self::getOneLevelMenu($item);
            } else {
                $str .= self::getMultiLevemMenu($item, $rol);
            }
        }

        return $str;
    }


    private static function getOneLevelMenu($root)
    {
        $str = "";
        $str .= '<li class="menu-item">';
        $str .= '<a class="menu-item-link" href="' . Url::base(true) . '/' . $root['url']  . '"><i class="' . $root['icon'] . '"></i> ' . $root['text'] . '</a>';
        $str .= '</li>';

        return $str;
    }

    private static function getMultiLevemMenu($root, $rol)
    {
        $str = "";
        $str .= '<li class="menu-item">';
        $str .= '<a class="" href="#" id="" role="button" ><i class="' . $root['icon'] . '"></i> ' . $root['text'] . '</a>';
        $str .= '<ul class="sub-menu">';
        foreach ($root['subItems'] as $item) {
            //Verifica si el rol del usuario está en la exepcion y no pinta la opcion
            if (isset($item['except-roles'])  and  in_array($rol, $item['except-roles'])) {
                continue;
            }
            $str .= '<li class="menu-item sub-menu-item">';
            $str .= '<a class="" href="' . Url::base(true) . "/" . $item['url'] . '"><i class="' . $item['icon'] . '"></i> ' . $item['text'] . '</a>';
            $str .= '</li>';
        }
        $str .= '</ul>';
        $str .= '</li>';

        return $str;
    }


}

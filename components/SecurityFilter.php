<?php
namespace app\components;

use app\dgomUtils\menu\RulesMenu;
use Yii;
use yii\base\ActionFilter;
use yii\web\HttpException;

class SecurityFilter extends ActionFilter
{


    public function beforeAction($action)
    {

       

        $reqController = Yii::$app->controller->id;
        $reqAction = Yii::$app->controller->action->id;

        $hasAccess = RulesMenu::hasAccess($reqController, $reqAction);

        if(!$hasAccess){
            throw new HttpException(403, "No tiene permiso para acceder al recurso solicitado");
        }
        
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        
        return parent::afterAction($action, $result);
    }
}


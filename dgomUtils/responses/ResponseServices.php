<?php
namespace app\dgomUtils\responses;
class ResponseServices{
    public $status = "error";
    public $message = "Ocurrio un error";
    public $result;

    function __construct() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }
}
?>
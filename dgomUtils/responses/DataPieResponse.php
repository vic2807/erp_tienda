<?php
namespace app\dgomUtils\responses;

class DataPieResponse{
    public $title           = "";
    public $subtitle        = "";
    public $unit            = "";
    public $responseCode    = 0;
    public $operation       = "";
    public $message         = "";
    public $data            = [];

    function addData($title, $val){
        $db = new DataBar();
        $db->name = $title;
        $db->value = $val;
        $this->data[] = $db;
    }

    public function getData(){
        return $this->data;
    }
    
}

class DataBar{
    public $name;
    public $value;
}

?>
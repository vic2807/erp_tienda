<?php
namespace app\dgomUtils\responses;

class DataBarResponse{

    public $title           = "";
    public $subtitle        = "";
    public $xAxis           = "";
    public $unit            = "";
    public $responseCode    = 0;
    public $operation       = "";
    public $message         = "";
    public $startDate       =  null;
    public $endDate         =  null;
    public $colNames        = [];
    public $data            = [];


    public function addColName($str){
        $this->colNames[] = $str;
    }

    public function getColName(){
        return $this->colNames;
    }

    public function addDataBar(DataBar $dta){
        $this->data[] = $dta;
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
<?php
namespace app\dgomUtils;

use Yii;

class Numbers{


    public static function formatDecimal($number, $pos){
        return number_format($number, $pos, '.', ',');
    }

}
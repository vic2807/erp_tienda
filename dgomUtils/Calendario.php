<?php

namespace app\dgomUtils;

use Yii;

class Calendario
{

    /**
     * Obtenemos la fecha actual para guardarla en la base de datos
     *
     * @return string
     */
    public static function getFechaActualTimeStamp()
    {
        date_default_timezone_set("America/Mexico_City");
        // Inicializamos la fecha y hora actual
        $fecha = date('Y-m-d H:i:s', time());
        return $fecha;
    }

    /**
     * Obtiene la fecha actual con el formato yyyy-mm-dd
     */
    public static function getFechaActualYYYYMMDD()
    {
        date_default_timezone_set("America/Mexico_City");
        // Inicializamos la fecha y hora actual
        $fecha = date('Y-m-d', time());
        return $fecha;
    }



    public static function getFechaTimeStamp($fch)
    {
        $time = strtotime($fch);
        $newformat = date('Y-m-d H:i:s', $time);
        return $newformat;
    }


    /**
     * Indica la fecha inicial de la semana de la fecha indicada
     */
    public static function inicioSemana($fecha)
    {
        $diaSemana = self::getNumberDayWeek($fecha);
        $inicioSemana = date("Y-m-d", strtotime($fecha . '-' . $diaSemana . ' day'));
        return $inicioSemana;
    }

    /**
     * Indica la fecha final de la semana de la fecha indicada
     */
    public static function finSemana($fecha)
    {
        $diaSemana = self::getNumberDayWeek($fecha);
        $suma = 6 - $diaSemana;
        $finSemana = date("Y-m-d", strtotime($fecha . '+' . $suma . ' day'));

        return $finSemana;
    }

    /**
     * Regresa la fecha indicada mas la cantidad de dias
     */
    public static function getDatePlusNDias($fecha, $numDays)
    {
        $inicioSemana = date("Y-m-d", strtotime($fecha . '+' . $numDays . ' day'));
        return $inicioSemana;
    }



    /**
     * Regresa la fecha indicada menos la cantidad de dias
     */
    public static function getDateMinusNDias($fecha, $numDays)
    {
        $inicioSemana = date("Y-m-d", strtotime($fecha . '-' . $numDays . ' day'));
        return $inicioSemana;
    }


    /**
     * Regresa la fecha indicada menos la cantidad de meses
     */
    public static function getDateMinusNMonths($fecha, $numMonths)
    {
        $inicioSemana = date("Y-m-d", strtotime($fecha . '-' . $numMonths . ' month'));
        return $inicioSemana;
    }


    //--------------- UTILIDADES -------------------------

    public static function getMesActual($string = null)
    {
        $tiempo = time();
        if ($string) {
            $tiempo = strtotime($string);
        }

        $fecha = date('Y-m', $tiempo);
        return $fecha;
    }

    public static function getMesAnterior($string, $numMes = 1)
    {

        $tiempo = time();
        if ($string) {
            $tiempo = strtotime($string . " -" . $numMes . " month");
        }

        $fecha = date('Y-m', $tiempo);
        return $fecha;
    }

    public static function getNumberWeek($string = null)
    {
        // Inicializamos la fecha y hora actual
        $tiempo = time();
        if ($string) {
            $tiempo = strtotime($string);
        }

        $fecha = date('W', $tiempo);

        return intval($fecha);
    }

    public static function getYear($string = null)
    {
        // Inicializamos la fecha y hora actual
        $tiempo = time();
        if ($string) {
            $tiempo = strtotime($string);
        }

        $fecha = date('Y', $tiempo);

        return intval($fecha);
    }

    /**
     * Regresa el nombre del día
     * @param string $string
     * @return string
     */
    public static function getDayName($string = null)
    {
        // Inicializamos la fecha y hora actual
        $tiempo = time();
        if ($string) {
            $tiempo = strtotime($string);
        }

        $fecha = date('N', $tiempo);


        $nombreDia = self::nombreDia($fecha);

        return $nombreDia;
    }

    /**
     * Regresa el número de la semana
     * @param string $string
     * @return string
     */
    public static function getNumberDayWeek($string = null)
    {
        // Inicializamos la fecha y hora actual
        $tiempo = time();
        if ($string) {
            $tiempo = strtotime($string);
        }

        $fecha = date('w', $tiempo);

        return $fecha;
    }

    /**
     * Regresa el número del día
     * @param string $string
     * @return string
     */
    public static function getDayNumber($string = null)
    {

        $tiempo = time();
        if ($string) {
            $tiempo = strtotime($string);
        }
        $diaNumero = date('d', $tiempo);

        return $diaNumero;
    }

    /**
     * Regresa el nombre del mes
     * @param string $string
     * @return string
     */
    public static function getMonthName($string = null)
    {
        // Inicializamos la fecha y hora actual

        $tiempo = time();
        if ($string) {
            $tiempo = strtotime($string);
        }
        $fecha = date('n', $tiempo);
        $nombreMes = self::nombreMes($fecha);

        return $nombreMes;
    }

    /**
     * Regresa el nombre del mes
     * @param string $string
     * @return string
     */
    public static function getPrevMonthNameFull($string = null)
    {
        // Inicializamos la fecha y hora actual

        $tiempo = strtotime("-1 month");
        if ($string) {
            $tiempo = strtotime($string);
        }
        $fecha = date('n', $tiempo);
        $nombreMes = self::nombreMesFull($fecha);

        return $nombreMes;
    }

    /**
     * Regresa el nombre del mes
     * @param string $string
     * @return string
     */
    public static function getMonthNameFull($string = null)
    {
        // Inicializamos la fecha y hora actual

        $tiempo = time();
        if ($string) {
            $tiempo = strtotime($string);
        }
        $fecha = date('n', $tiempo);
        $nombreMes = self::nombreMesFull($fecha);

        return $nombreMes;
    }

    /**
     * Regresa el número del mes
     * @param string $string
     * @return string
     */
    public static function getMonthNumber($string = null)
    {
        // Inicializamos la fecha y hora actual

        $tiempo = time();
        if ($string) {
            $tiempo = strtotime($string);
        }
        $fecha = date('m', $tiempo);


        return $fecha;
    }

    /**
     * Regresa los 2 últimos números del año
     * @param string $string
     * @return string
     */
    public static function getYearLastDigit($string = null)
    {

        $tiempo = time();
        if ($string) {
            $tiempo = strtotime($string);
        }
        $fecha = date('y', $tiempo);

        return $fecha;
    }

    /**
     * Regresa la fecha completa con hora -> VIERNES 03-MAY-19 13:37
     * @param string $string
     * @return string
     */
    public static function getDateCompleteHour($string)
    {
        $nombreDia  = self::getDayName($string);
        $dia        = self::getDayNumber($string);
        $mes        = self::getMonthName($string);
        $anio       = self::getYearLastDigit($string);
        $hora       = self::getHoursMinutes($string);

        return $nombreDia . " " . $dia . "-" . $mes . "-" . $anio . " " . $hora;
    }

    public static function formatDate($string)
    {
        return self::getDateComplete($string);
    }

    /**
     * Regresa la fecha completa -> VIERNES 03-MAY-19
     * @param string $string
     * @return string
     */
    public static function getDateComplete($string)
    {
        $nombreDia = self::getDayName($string);
        $dia = self::getDayNumber($string);
        $mes = self::getMonthName($string);
        $anio = self::getYearLastDigit($string);


        return $nombreDia . " " . $dia . "-" . $mes . "-" . $anio;
    }

    /**
     * Regresa la fecha completa -> 03-MAY-19
     * @param string $string
     * @return string
     */
    public static function getDateDDMMYY($string)
    {
        $dia = self::getDayNumber($string);
        $mes = self::getMonthName($string);
        $anio = self::getYearLastDigit($string);


        return $dia . "-" . $mes . "-" . $anio;
    }

    /**
     * Regresa la fecha a partir de mes -> MAY-2019
     * @param string $string
     * @return string
     */
    public static function getDateMMYYYY($string)
    {
        $mes = self::getMonthName($string);
        $anio = date('Y', strtotime($string));

        return $mes . "-" . $anio;
    }

    /**
     * Regresa la fecha completa -> VIERNES 03-MAY
     * @param string $string
     * @return string
     */
    public static function getDateDayMonth($string)
    {
        $nombreDia = self::getDayName($string);
        $dia = self::getDayNumber($string);
        $mes = self::getMonthName($string);
        $anio = self::getYearLastDigit($string);


        return $nombreDia . " " . $dia . "-" . $mes;
    }

    /**
     * Regresa la hora y minutos
     * @param string $string
     * @return string
     */
    public static function getHoursMinutes($string = null)
    {
        $tiempo = time();
        if ($string) {
            $tiempo = strtotime($string);
        }
        $fecha = date('H:i', $tiempo);

        return $fecha;
    }


    /**
     * Regresa el nombre mes dependiendo del número
     * @param string $fecha
     * @return string
     */
    public static function nombreMes($fecha)
    {
        $nombreMes = '';
        switch ($fecha) {
            case '1':
                $nombreMes = 'Ene';
                break;
            case '2':
                $nombreMes = 'Feb';
                break;
            case '3':
                $nombreMes = 'Mar';
                break;
            case '4':
                $nombreMes = 'Abr';
                break;
            case '5':
                $nombreMes = 'May';
                break;
            case '6':
                $nombreMes = 'Jun';
                break;
            case '7':
                $nombreMes = 'Jul';
                break;
            case '8':
                $nombreMes = 'Ago';
                break;
            case '9':
                $nombreMes = 'Sep';
                break;
            case '10':
                $nombreMes = 'Oct';
                break;
            case '11':
                $nombreMes = 'Nov';
                break;
            case '12':
                $nombreMes = 'Dic';
                break;
            default:
                # code...
                break;
        }

        return $nombreMes;
    }

    /**
     * Regresa el nombre mes dependiendo del número
     * @param string $fecha
     * @return string
     */
    public static function nombreMesFull($fecha)
    {
        $nombreMes = '';
        switch ($fecha) {
            case '1':
                $nombreMes = 'Enero';
                break;
            case '2':
                $nombreMes = 'Febrero';
                break;
            case '3':
                $nombreMes = 'Marzo';
                break;
            case '4':
                $nombreMes = 'Abril';
                break;
            case '5':
                $nombreMes = 'Mayo';
                break;
            case '6':
                $nombreMes = 'Junio';
                break;
            case '7':
                $nombreMes = 'Julio';
                break;
            case '8':
                $nombreMes = 'Agosto';
                break;
            case '9':
                $nombreMes = 'Septiembre';
                break;
            case '10':
                $nombreMes = 'Octubre';
                break;
            case '11':
                $nombreMes = 'Noviembre';
                break;
            case '12':
                $nombreMes = 'Diciembre';
                break;
            default:
                # code...
                break;
        }

        return $nombreMes;
    }

    /**
     * Regresa el numero de mes
     * @param string $fecha
     * @return string
     */
    public static function nameMonthNumber($fecha)
    {
        $numberMonth = '';
        switch ($fecha) {
            case 'Enero':
                $numberMonth = '01';
                break;
            case 'Febrero':
                $numberMonth = '02';
                break;
            case 'Marzo':
                $numberMonth = '03';
                break;
            case 'Abril':
                $numberMonth = '04';
                break;
            case 'Mayo':
                $numberMonth = '05';
                break;
            case 'Junio':
                $numberMonth = '06';
                break;
            case 'Julio':
                $numberMonth = '07';
                break;
            case 'Agosto':
                $numberMonth = '08';
                break;
            case 'Septiembre':
                $numberMonth = '09';
                break;
            case 'Octubre':
                $numberMonth = '10';
                break;
            case 'Noviembre':
                $numberMonth = '11';
                break;
            case 'Diciembre':
                $numberMonth = '12';
                break;
            default:
                break;
        }

        return $numberMonth;
    }

    /**
     * Regresa el nombre del día
     * @param string $fecha
     * @return string
     */
    public static function nombreDia($fecha)
    {
        $dayName = '';
        switch ($fecha) {
            case '1':
                $dayName = 'Lunes';
                break;
            case '2':
                $dayName = 'Martes';
                break;
            case '3':
                $dayName = 'Miércoles';
                break;
            case '4':
                $dayName = 'Jueves';
                break;
            case '5':
                $dayName = 'Viernes';
                break;
            case '6':
                $dayName = 'Sábado';
                break;
            case '7':
                $dayName = 'Domingo';
                break;
        }

        return $dayName;
    }



    /**
     * Return value is 0 if both dates are equal.
     * Return value is greater than 0 , if Date is after the date argument.
     * Return value is less than 0, if Date is before the date argument.
     */
    public static function compareWithTodayDateTime($fch)
    {
        date_default_timezone_set("America/Mexico_City");
        $today = date("Y-m-d H:i:s");
        $date = $fch;
        if ($date < $today) {
            return -1;
        } else if ($today < $date) {
            return 1;
        } else {
            return 0;
        }
    }


    /**
     * Numero de semanas en un año
     */
    public static function getIsoWeeksInYear($year)
    {
        $date = new \DateTime;
        $date->setISODate($year, 53);
        return ($date->format("W") === "53" ? 53 : 52);
    }

    /**
     * Numero de meses entre dos fechas "2021-12-01"
     */
    public static function getNumberOfMonths($date_start, $date_end)
    {

        $arr_date_start = explode('-', $date_start);
        $arr_date_end = explode('-', $date_end);
        $diff_years = $arr_date_end[0] - $arr_date_start[0];
        if ($diff_years > 0) {
            $meses_consignados = (12 - $arr_date_start[1]) + (($diff_years - 1) * 12) + $arr_date_end[1];
            return $meses_consignados;
        }
        $meses_consignados = (($arr_date_end[1] - $arr_date_start[1]) == 0) ? 1 : $arr_date_end[1] - $arr_date_start[1];
        return $meses_consignados;

        /* Diferencia de meses con base en dias
        $months_float = (strtotime($date_end) - strtotime($date_start))/60/60/24/30;
        $whole = floor($months_float);
        $fraction = $months_float - $whole;
        if($months_float <= 1){ //menor a 30 dias
            return 1;
        }elseif($months_float > 0 && $fraction >= .06){ //mayor a 31 dias y menor a 60
            $whole += 1;
            return $whole; 
        }elseif($months_float > 0 && $fraction < .06){
            return $whole;
        }
        */
    }
}

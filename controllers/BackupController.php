<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\components\ActionTimeFilter;
use app\components\SecurityFilter;
use app\dgomUtils\Calendario;
use app\models\BaseAppsBackups;
use ZipArchive;

class BackupController extends Controller
{

    public function behaviors()
    {
        return [
            
            'security' => [
                'class' => SecurityFilter::class,
                'only' => ['*']
            ],
            'actionTime' => [
                'class' => ActionTimeFilter::class,
                'only' => ['*']
            ],
            
        ];
    }

    public function actionIndex()
    {

        $data = BaseAppsBackups::getListAll();

        return $this->render('index',['data'=>$data]);
    }

    public function actionDbBkup($tables = '*'){
       
        $databaseBkup = $this->backupDatabaseLarge();
        $zipFilePath = "backups/db/";
        $uuidName = uniqid("dbbk_");
        $zipFileName = $zipFilePath . $uuidName;
        $isError = false;

        //Crea los directorios
        if (!file_exists($zipFilePath)) {
            mkdir($zipFilePath, 0755, true);
        }

        $zip = new ZipArchive;
        $res = $zip->open($zipFileName . '.zip', ZipArchive::CREATE);
        if ($res === TRUE) {
            $zip->addFromString('backup.sql', $databaseBkup);
            $zip->close();
           
        } else {
            //echo 'failed';
            $isError = true;
            Yii::$app->session->setFlash('error', "No se pudo generar el respaldo");
        }

        //---------

        if(!$isError){
            $model = new BaseAppsBackups();
            $model->uuid = $uuidName;
            $model->b_habilitado = 1;
            $model->b_database = 1;
            $model->fch_fecha_backup = Calendario::getFechaActualTimeStamp();
            $model->save();
        }


        return $this->redirect('index');
    }


    private function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }

    /**
     * https://circ.cs.southern.edu/wiki/doku.php?id=tutorial:yii2:database_backup
     * Dumps the MySQL database that this controller's model is attached to.
     * This action will serve the sql file as a download so that the user can save the backup to their local computer.
     *
     * @param string $tables Comma separated list of tables you want to download, or '*' if you want to download them all.
     */
    private function backupDatabaseLarge($tables = '*') 
    {
        $triggers = 'x';
        $is_data_included = true;
        //ini_set('memory_limit','64M');  // limit memory to 64MB
        ini_set('memory_limit','-1');     // no memory limit
 
        //Yii::$app->response->format = Response::FORMAT_RAW;  // Raw for Text output
 
        $strReturn = "";
 
        $db = Yii::$app->getDb();
        $databaseName = $this->getDsnAttribute('dbname', $db->dsn);
 
        // Set the default file name
        $fileName = $databaseName . '-backup-' . date('Y-m-d_H-i-s') . '.sql';
 
        // Serve the file as a download
        // header("Content-Type: text/x-sql");
        // header("Content-Disposition: attachment; filename='{$fileName}'");  // File will be called $fileName
        // // Disable caching - HTTP 1.1
        // header("Cache-Control: no-cache, no-store, must-revalidate");
        // // Disable caching - HTTP 1.0
        // header("Pragma: no-cache");
        // // Disable caching - Proxies
        // header("Expires: 0");
 
        // Do a short SQL header
        $strReturn .= "-- Database: `{$databaseName}`\n";
        $strReturn .= "-- Generation time: " . date('D jS M Y H:i:s') . "\n\n\n";
 
        //-----------------
        // Tables & Views
        //-----------------
        if ($tables == '*') {
            $tables = array();
            $result = $db->createCommand('SHOW TABLES')->queryAll();
            foreach($result as $resultKey => $resultValue) {
                $tables[] = $resultValue["Tables_in_{$databaseName}"];
            }
            //$strReturn .= "Tables: " . print_r($tables, true);  //debug
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }
 
        // Run through all the tables
        foreach ($tables as $table) {
            if ($is_data_included) {
                $tableCountData = $db->createCommand("SELECT COUNT(*) AS total FROM `{$table}`")->queryAll();
                $totalRecs = $tableCountData[0]['total'];
                //$strReturn .= "Total: " . print_r($tableCountData, true);  //debug
            }
 
            // SQL CREATE code
            $strReturn .= "DROP TABLE IF EXISTS `{$table}`;";
 
            // Tables
            try {
                $createTableResult = $db->createCommand("SHOW CREATE TABLE `{$table}`")->queryAll();
                $createTableEntry = current($createTableResult);
                if (!empty($createTableEntry['Create Table'])) {
                    $strReturn .= "\n\n" . $createTableEntry['Create Table'] . ";\n\n";
                }
            } catch (\Exception $e) {
                //throw new \Exception($e->getMessage() . ":\n" . json_encode($dumped), 0, $e);
                $strReturn .= "\n\n-- No table definition for '{$table}'\n\n";
            }
 
            // Views
            try {
                $createViewResult = $db->createCommand("SHOW CREATE VIEW `{$table}`")->queryAll();
                $createViewEntry = current($createViewResult);
                if (!empty($createViewEntry['Create View'])) {
                    $strReturn .= "\n\n" . $createViewEntry['Create View'] . ";\n\n";
                }
            } catch (\Exception $e) {
                //throw new \Exception($e->getMessage() . ":\n" . json_encode($dumped), 0, $e);
                //$strReturn .= "\n\n-- No view definition for '" . $table . "'\n\n";
            }
 
            if ($is_data_included) {
                // Process table data in chunks to avoid running out of memory
                for($startIdx = 0, $chunkSize = 10000; $startIdx < $totalRecs; $startIdx += $chunkSize) {
                    $tableData = $db->createCommand("SELECT * FROM `{$table}` LIMIT {$startIdx},{$chunkSize}")->queryAll();
 
                    // Output the table data
                    foreach($tableData as $tableRowIndex => $tableRow) {
                        $strReturn .= "INSERT INTO `{$table}` VALUES(";
 
                        foreach($tableRow as $fieldName => $fieldValue) {
                            if(is_null($fieldValue)) {
                                $escapedFieldValue = 'NULL';
                            } else {
                                // Convert the encoding
                                //$escapedFieldValue = mb_convert_encoding( $fieldValue, "UTF-8", "ISO-8859-1" );
                                $escapedFieldValue = $fieldValue;  // no char conversion (keep it as UTF-8)
 
                                // Escape any apostrophes using the datasource of the model.
                                $escapedFieldValue = str_replace("'", "\'", $escapedFieldValue);  // escape apostrophes
                                //if (stripos($escapedFieldValue, ' ') !== false) {
                                //    $escapedFieldValue = "'{$escapedFieldValue}'";  // quote string if spaces found
                                //}
                                //if (!is_numeric($escapedFieldValue)) {
                                //    $escapedFieldValue = "'{$escapedFieldValue}'";  // quote string if non-numeric
                                //}
                                $escapedFieldValue = "'{$escapedFieldValue}'";        // quote string for all fields without NULL
                            }
 
                            $tableRow[$fieldName] = $escapedFieldValue;
                        }
                        $strReturn .= implode(',', $tableRow);
 
                        $strReturn .= ");\n";
                    }
                }
            }
 
            $strReturn .= "\n\n\n";
        }
 
        $strReturn .= "\n\n\n";
 
        //-----------------
        // Triggers
        //-----------------
        // if ($triggers == '*') {
        //     $triggers = array();
        //     $result = $db->createCommand('SHOW TRIGGERS')->queryAll();
        //     foreach($result as $resultKey => $resultValue) {
        //         $triggers[] = $resultValue['Trigger'];
        //     }
        // } else {
        //     $triggers = is_array($triggers) ? $triggers : explode(',', $triggers);
        // }
 
        // // Run through all the triggers
        // $strReturn .= "\n\n-- Triggers \n\n";
        // foreach ($triggers as $trigger) {
        //     $strReturn .= "DROP TRIGGER IF EXISTS `{$trigger}`;";
        //     // Triggers
        //     $createTriggerResult = $db->createCommand("SHOW CREATE TRIGGER `{$trigger}`")->queryAll();
        //     $createTriggerEntry = current($createTriggerResult);
        //     //if (!empty($createTriggerEntry['sql_mode'])) {
        //     //    $strReturn .= "\n\n" . $createTriggerEntry['sql_mode'] . ";\n\n";
        //     //}
        //     if (!empty($createTriggerEntry['SQL Original Statement'])) {
        //         $strReturn .= "\n\n" . $createTriggerEntry['SQL Original Statement'] . ";\n\n";
        //     }
        //     //if (!empty($createTriggerEntry['character_set_client'])) {
        //     //    $strReturn .= "\n\n" . $createTriggerEntry['character_set_client'] . ";\n\n";
        //     //}
        //     //if (!empty($createTriggerEntry['collation_connection'])) {
        //     //    $strReturn .= "\n\n" . $createTriggerEntry['collation_connection'] . ";\n\n";
        //     //}
        //     //if (!empty($createTriggerEntry['Database Collation'])) {
        //     //    $strReturn .= "\n\n" . $createTriggerEntry['Database Collation'] . ";\n\n";
        //     //}
 
        //     $strReturn .= "\n\n\n";
        // }
 
        return $strReturn;
        //Yii::$app->response->data = $strReturn;
    }




   
}

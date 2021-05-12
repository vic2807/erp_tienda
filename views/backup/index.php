<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = "Backup Util";
$this->params['breadcrumbs'][] = "Utilidades";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="body-content">
    <a href="<?=Url::base()?>/backup/db-bkup" class="btn btn-primary">Backup Base de datos</a>


    <table class="table table-striped">
        <thead>
            <tr>
                <th>UUID</th>
                <th>Fecha</th>
                <th>Base de datos</th>
                <th>Acciones</th>
            </tr>

        </thead>
        <tbody>
            <?foreach($data as $item): ?>
                <tr>
                    <td><?=$item->uuid?></td>
                    <td><?=$item->fch_fecha_backup?></td>
                    <td><?=$item->b_database?></td>
                    <td><a href="<?=Url::base()?>/backups/db/<?=$item->uuid?>.zip">DESCARGAR</a></td>
                </tr>
            <?endforeach?>
        </tbody>
    </table>

</div>

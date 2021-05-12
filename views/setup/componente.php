<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $componente->txt_componente;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="body-content">

<div class="row">
    <div class="col-md-3">
        <div class="list-group ">
            <div class="list-group-item list-group-item-action list-group-item-light active">
                Componentes
            </div>
            <?php
            foreach ($componentes as $componenteItem) {
                ?>
                <a href="<?= Url::base() ?>/setup/site-config?uudi=<?= $componenteItem->txt_componente ?>" class="list-group-item list-group-item-action <?= $componenteItem->txt_componente == $componente->txt_componente ? "list-group-item-info" : '' ?>"><?= $componenteItem->txt_componente ?></a>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="col-md-9">
        <h2>
            <?= $this->title ?>
            <div class="float-right">
                <?= $componente->elementoEnabled ?>
            </div><br>
        </h2>
        <?php
        if ($componente->txt_url_documentacion) {
            ?>

            <small><?= Html::a('Ver documentación', $componente->txt_url_documentacion, ["target" => "_blank"]) ?></small>
        <?php
        }
        ?>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <?php
                foreach ($configuraciones as $configuracion) {
                    echo $this->render("_configuracion", [
                        "configuracion" => $configuracion
                    ]);
                }
                ?>
            </div>
        </div>
    </div>
</div>
</div>
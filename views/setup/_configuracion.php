<?php

use yii\bootstrap\ActiveForm;
use app\components\HtmlExtends;
?>

<?php $form = ActiveForm::begin(["id" => "form-configuracion-" . $configuracion->id_configuracion, "action" => "update?uudi=" . $configuracion->id_configuracion, "options" => ["class" => "ajax"]]); ?>
<div class="row">
    <div class="col-md-4">
        <p>
            <strong>
                <?= $configuracion->txt_propiedad ?>
            </strong>
            <br>
            <small><?= $configuracion->txt_descripcion ?></small>
        </p>
    </div>
    <div class="col-md-4">
        <?= $configuracion->getPropertyByEnvironmentInput($form) ?>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?= HtmlExtends::submitButtonLadda('Guardar', ['class' => 'btn btn-outline-success']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
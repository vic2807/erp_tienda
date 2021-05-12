<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Actualizar usuario del sistema: ' . $model->nombreCompleto;

$this->params['breadcrumbs'][] = ['label' => 'Usuarios del sistema', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';

$mapStatusUsuarioList = ArrayHelper::map($statusUsuarioList, 'id_status', 'txt_nombre');
$mapRolesUsuarioList = ArrayHelper::map($rolesUsuarioList, 'id_usuario_rol', 'txt_nombre');
?>
<div class="mod-usuarios-ent-usuarios-update body-content">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'statusUsuarioList' => $statusUsuarioList,
        'rolesUsuarioList' => $rolesUsuarioList,
        'mapStatusUsuarioList' =>$mapStatusUsuarioList,
        'mapRolesUsuarioList'=>$mapRolesUsuarioList,
    ]) ?>

</div>
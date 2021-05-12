<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$mapStatusUsuarioList = ArrayHelper::map($statusUsuarioList, 'id_status', 'txt_nombre');
$mapRolesUsuarioList = ArrayHelper::map($rolesUsuarioList, 'id_usuario_rol', 'txt_nombre');

$this->title = 'Crear Usuario';

$this->params['breadcrumbs'][] = ['label' => 'Usuarios del sistema', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="mod-usuar
ios-ent-usuarios-create body-content">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="mod-usuarios-ent-usuarios-form">

        <?php $form = ActiveForm::begin(); ?>

        <? //= $form->field($model, 'txt_token')->textInput(['maxlength' => true]) 
        ?>

        <? //= $form->field($model, 'txt_imagen')->textInput(['maxlength' => true]) 
        ?>

        <?= $form->field($model, 'txt_username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'txt_apellido_paterno')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'txt_apellido_materno')->textInput(['maxlength' => true]) ?>

        <? //= $form->field($model, 'txt_auth_key')->textInput(['maxlength' => true]) 
        ?>

        <? //= $form->field($model, 'txt_password_hash')->textInput(['maxlength' => true]) 
        ?>

        <? //= $form->field($model, 'txt_password_reset_token')->textInput(['maxlength' => true]) 
        ?>

        <?= $form->field($model, 'txt_email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'txt_password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'repeatPassword')->passwordInput(['maxlength' => true]) ?>

        <? //= $form->field($model, 'fch_creacion')->textInput() 
        ?>

        <? //= $form->field($model, 'fch_actualizacion')->textInput() 
        ?>

        <?= $form->field($model, 'id_status')->dropDownList(
            $mapStatusUsuarioList,
            ['prompt' => 'Estatus del usuario']
        ); ?>

        <?= $form->field($model, 'id_rol_usuario')->dropDownList(
            $mapRolesUsuarioList,
            ['prompt' => 'Estatus del usuario']
        ); ?>

        <? //= $form->field($model, 'b_remember_me')->textInput() 
        ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?= $form->errorSummary($model); ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>
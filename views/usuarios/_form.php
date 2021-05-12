<?

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>


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
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
</div>

<?= $form->errorSummary($model); ?>

<?php ActiveForm::end(); ?>
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\dgomUtils\setup\SetupUtils;

$this->title = 'Crear Cuenta de sistema: Merck';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login page">

    <div class="login-form-wrapper">

        <img class="login_form_logo" src="<?= Url::base(true) . SITE_LOGO ?>" srcset="<?= Url::base(true) . SITE_LOGO2X ?> 2x" alt="">
        <?php $form = ActiveForm::begin([
            'id' => 'sign-up-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"form_input\">{input}</div>\n<div class=\"\">{error}</div>",
                'labelOptions' => ['class' => 'form_label'],
            ], 'options' => ['class' => 'form-register']
        ]); ?>

        <h3 class="login_form_title">Ingrese los datos solicitados para crear una cuenta</h3>

        <div class="col-wrapper form-colum-wrapper">
            <div class="col-left">
                <?= $form->field($model, 'txt_username', ['template' => "<div class=\"form-group-inputs\">{label}\n<div class=\"form_input\"><i class=\"form_icon icon icon_lg ion-ios-person-outline\"></i>{input}</div>\n<div class=\"\">{error}</div></div>"])->textInput() ?>
                <?= $form->field($model, 'txt_apellido_paterno', ['template' => "<div class=\"form-group-inputs\">{label}\n<div class=\"form_input\"><i class=\"form_icon icon icon_lg ion-ios-person-outline\"></i>{input}</div>\n<div class=\"\">{error}</div></div>"])->textInput() ?>
                <?= $form->field($model, 'txt_apellido_materno', ['template' => "<div class=\"form-group-inputs\">{label}\n<div class=\"form_input\"><i class=\"form_icon icon icon_lg ion-ios-person-outline\"></i>{input}</div>\n<div class=\"\">{error}</div></div>"])->textInput() ?>
                <?= $form->field($model, 'txt_email', ['enableAjaxValidation' => true, 'template' => "<div class=\"form-group-inputs\">{label}\n<div class=\"form_input\"><i class=\"form_icon icon icon_lg ion-ios-email-outline\"></i>{input}</div>\n<div class=\"\">{error}</div></div>"])->textInput() ?>
                <?= $form->field($model, 'repeatEmail', ['template' => "<div class=\"form-group-inputs\">{label}\n<div class=\"form_input\"><i class=\"form_icon icon icon_lg ion-ios-email-outline\"></i>{input}</div>\n<div class=\"\">{error}</div></div>"])->textInput() ?>
            </div>
            <div class="col-right">
                <?= $form->field($model, 'txt_password', ['template' => "<div class=\"form-group-inputs\">{label}\n<div class=\"form_input\"><i class=\"form_icon icon icon_lg ion-ios-locked-outline\"></i>{input}</div>\n<div class=\"\">{error}</div></div>"])->passwordInput() ?>
                <?= $form->field($model, 'repeatPassword', ['template' => "<div class=\"form-group-inputs\">{label}\n<div class=\"form_input\"><i class=\"form_icon icon icon_lg ion-ios-locked-outline\"></i>{input}</div>\n<div class=\"\">{error}</div></div>"])->passwordInput() ?>
                <?php
                if(SetupUtils::getString(SetupUtils::SISTEMA_SINGUP_TYPE) == 2){
                    echo $form->field($model, 'codigo', ['enableAjaxValidation' => true, 'template' => "<div class=\"form-group-inputs\">{label}\n<div class=\"form_input\"><i class=\"form_icon icon icon_lg ion-ios-barcode-outline\"></i>{input}</div>\n<div class=\"\">{error}</div></div>"])->textInput(['maxlength' => true,]); 
                }
                ?>
                <!-- TODO validar los terminos y ponerlos como forzosos -->
                <?= $form->field($model, 'aceptarTerminos', ["template" => "{input}{label}{hint}{error}", "options" => ["class" => "checkbox-custom checkbox-primary dgom-aceptar-terminos"]])->checkbox(['class' => 'js-aceptar-terminos'], false) 
                ?>

            </div>
        </div>

        <div class="form-group">
            <div class="">
                <?= Html::submitButton('Crear cuenta', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <h6 class="recuperar-pass-title">¿Ya tiene cuenta?</h6>
        <span class="recuperar-pass">Dé click <a class="inline-btn" href="<?= Url::base(true) ?>/site/login">aquí</a> para ir a la pantalla de ingreso.</span>


        <?php ActiveForm::end(); ?>


    </div>

</div>
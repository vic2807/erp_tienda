<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Ingreso a sistema';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login page">
    <div class="login-form-wrapper">
        <img class="login_form_logo" src="<?= Url::base(true) . SITE_LOGO ?>" srcset="<?= Url::base(true) . SITE_LOGO2X ?> 2x" alt="">

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"form_input\">{input}</div>\n<div class=\"\">{error}</div>",
                'labelOptions' => ['class' => 'form_label'],
            ],
        ]); ?>

        <h3 class="login_form_title">Ingrese a su cuenta</h3>

        <?= $form->field($model, 'txt_email', ['template' => "{label}\n<div class=\"form_input\"><i class=\"form_icon icon icon_lg ion-ios-email-outline\"></i>{input}</div>\n<div class=\"\">{error}</div>"])->textInput(['autofocus' => true, 'options']) ?>

        <?= $form->field($model, 'txt_password', ['template' => "{label}\n<div class=\"form_input\"><i class=\"form_icon icon icon_lg ion-ios-locked-outline\"></i>{input}</div>\n<div class=\"\">{error}</div>"])->passwordInput() ?>

        <div class="form-group">
            <div class="">
                <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary btn-primary_login', 'name' => 'login-button']) ?>
            </div>
        </div>

        <h6 class="recuperar-pass-title">¿Perdió su contraseña?</h6>
        <span class="recuperar-pass">Descuide, dé click <a class="inline-btn" href="<?= Url::base(true) ?>/site/recuperar-password">aquí</a> para recuperarla</span>
        <?php ActiveForm::end(); ?>
    </div>
</div>
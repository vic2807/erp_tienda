<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Cambiar contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="site-login page">

    <img class="login_bkgd_image" src="<?= Url::base(true) ?>/dgom_web_assets/images/backgrounds/login-bkgd.jpg" alt="">

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

        <h3 class="login_form_title">Cambiar contraseña</h3>

        <?= $form->field($model, 'txt_password', ['template' => "{label}\n<div class=\"form_input\"><i class=\"form_icon icon icon_lg ion-ios-locked-outline\"></i>{input}</div>\n<div class=\"\">{error}</div>"])->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'repeatPassword', ['template' => "{label}\n<div class=\"form_input\"><i class=\"form_icon icon icon_lg ion-ios-locked-outline\"></i>{input}</div>\n<div class=\"\">{error}</div>"])->passwordInput(['maxlength' => true]) ?>

        <div class="form-group">
            <div class="">
                <?= Html::submitButton('Actualizar contraseña', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <h6 class="recuperar-pass-title">¿No sabe como llego aquí?</h6>
        <span class="recuperar-pass">Descuide, de click <a class="recuperar-pass-btn" href="<?= Url::base(true) ?>/site/login">aquí</a> para ir al inicio</span>


        <?php ActiveForm::end(); ?>


    </div>

</div>
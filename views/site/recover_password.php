<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'Recuperar contraseña';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("
    $(document).ready(function(){

        toast();
    });
", View::POS_READY);
?>

<div class="site-login page">

    <img class="login_bkgd_image" src="<?= Url::base(true) ?>/dgom_web_assets/images/backgrounds/login-bkgd.jpg" alt="">

    <div class="login-form-wrapper">

        <!-- FLASH MESSAGES -- -->
        <?php if (Yii::$app->session->hasFlash('success')) : ?>

            <script>
                var showToast = true;
            </script>

        <?php endif; ?>


        <img class="login_form_logo" src="<?= Url::base(true) . SITE_LOGO ?>" srcset="<?= Url::base(true) . SITE_LOGO2X ?> 2x" alt="">

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"form_input\">{input}</div>\n<div class=\"\">{error}</div>",
                'labelOptions' => ['class' => 'form_label'],
            ],
            'options' => [
                'class' => 'login-form-recover-pass',
            ]
        ]); ?>

        <h3 class="login_form_title">Recuperación de contraseña</h3>

        <?= $form->field($model, 'txt_email', ['enableAjaxValidation' => true, 'template' => "<div class=\"form-group-inputs\">{label}\n<div class=\"form_input\"><i class=\"form_icon icon icon_lg ion-ios-email-outline\"></i>{input}</div>\n<div class=\"\">{error}</div></div>"])->textInput() ?>


        <div class="form-group">
            <div class="">
                <?= Html::submitButton('Recuperar contraseña', ['class' => 'btn btn-primary btn-primary_login', 'name' => 'login-button']) ?>
            </div>
        </div>

        <h6 class="recuperar-pass-title">¿Ya tiene una cuenta?</h6>
        <span class="recuperar-pass">Descuide, dé click <a class="inline-btn" href="<?= Url::base(true) ?>/site/login">aquí</a> para ingresar normalmente</span>


        <?php ActiveForm::end(); ?>


    </div>



</div>
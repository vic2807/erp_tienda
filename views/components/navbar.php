<?php

use yii\helpers\Url;
use app\assets\AppAsset;
use app\dgomUtils\menu\RulesMenu;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>


<nav class="webapp-nav">
    <a class="system-logo" href="<?= Url::base() ?>/" title="<?= Yii::$app->name ?>">
        <!-- Forzamos la imagen a 2x en ambos casos de resolucion para que se vea mejor en no retina -->
        <img class="nav-bar-system-logo" src="<?= Url::base(true) . SITE_NAV_LOGO ?>" srcset="<?= Url::base(true) . SITE_NAV_LOGO2X ?> 2x" alt="">
    </a>
    <div class="menu">
        <?/*= RulesMenu::getNavBar() */?>
       
    </div>
    <div class="user-menu">
        <?
        if (\Yii::$app->user->isGuest) {
            echo '<a class="" href="' . Url::base(true) . '/site/login"><i class="fas fa-sign-in-alt"></i> Entrar</a>';
        } else {
            ?>
            <a class="" href="<?= Url::base(true) ?>/site/logout">
                <?= Yii::$app->user->identity->txt_email ?><i class="toolbar-icon-logout ion-log-out"></i>
            </a>
        <?
        }
        ?>
    </div>
</nav>
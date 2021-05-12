<?php

use yii\helpers\Url;
?>
<div class="browser-detect-wrapper">
    <div class="browser-detect-overlay">
    </div>
    <div class="browser-detect-modal">
        <h3>Aviso navegador no compatible</h3>
        <p>Detectamos que esta consultando este portal desde los navegadores <span class="strong">Internet Explorer o Edge Explorer de Microsoft</span></p>
        <p>
            Para tener la mejor experiencia al hacer uso de este portal le recomendamos descargar alguno de los siguientes navegadores:
        </p>
        <div class="browsers-wrapper">
            <a href="https://www.mozilla.org/es-MX/firefox/new/"><img src="<?= Url::base() ?>/dgom_web_assets/images/browser-logos/firefox.png" alt="">Firefox</a>
            <a href="https://www.google.com/chrome/?brand=CHBD&gclid=CjwKCAjwx_boBRA9EiwA4kIELoIjugX04Tho2j7yHDv2gr6sPfAzTFz0bMlOLxo6cwV_y2H98kfj2xoCUUwQAvD_BwE&gclsrc=aw.ds"><img src="<?= Url::base() ?>/dgom_web_assets/images/browser-logos/chrome.png" alt="">Chrome</a>
            <!-- <a href=""><img src="<?= Url::base() ?>/dgom_web_assets/images/browser-logos/safari.png" alt="">Safari (solo mac)</a> -->
        </div>
        <p>
            Solo de click en alguno para ir a la página de descarga
        </p>
        <p>
            O bien si desea continuar con su navegador actual de click <span class="js-continuar btn-login-alert-continue">aquí</span>
        </p>
    </div>
</div>
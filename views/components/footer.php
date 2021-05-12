<?php

use yii\helpers\Url;
?>

<div class="footer">
    <div class="footer-wrapper">
        <div class="footer-company-name">
            &copy; Codelang <?= date('Y') ?>
        </div>

        <div class="footer-developer-name">
            <a href="" target="_blank">
                <h6>Developed by</h6>
                <img src="<?= Url::base() . FOOTER_LOGO ?>" alt="2GOM">
            </a>
        </div>
    </div>
</div>
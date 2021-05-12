<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// Constants
define('SITE_LOGO'  , '/dgom_web_assets/images/logos/logo.png');
define('SITE_LOGO2X'  , '/dgom_web_assets/images/logos/logo@2x.png');
define('SITE_NAV_LOGO', '/dgom_web_assets/images/logos/nav_logo.png');
define('SITE_NAV_LOGO2X', '/dgom_web_assets/images/logos/nav_logo@2x.png');
define('MAIL_LOGO'  , '/dgom_web_assets/images/mail/logo.png');
define('FOOTER_LOGO', '/dgom_web_assets/images/2gom/footer_logo.svg');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();

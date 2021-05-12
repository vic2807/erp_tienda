<?php

use app\assets\AppAsset;


AppAsset::register($this);

$this->registerJsFile(
    '@web/dgom_web_assets/js/dgom-browser_detect.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<?= $this->render("//components/head") ?>


<?php $this->beginBody() ?>
<?= $content ?>
<?= $this->render("//components/browser-detect.php") ?>

<?php $this->endBody() ?>

</html>
<?= $this->render("//components/footer") ?>
<?php $this->endPage() ?>
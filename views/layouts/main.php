<?php

use app\widgets\Alert;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;


AppAsset::register($this);
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<?= $this->render("//components/head") ?>


<?php $this->beginBody() ?>

<div class="page">
    <div class="container">
        <?= $this->render("//components/navbar") ?>
            <div class="page-view">
            <?echo Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'options'=>['class' => 'breadcrumb'],
                'homeLink' => false
            ]);?>
            <?= $content ?>
            </div>
    </div>
</div>

<?= $this->render("//components/footer") ?>

<?php $this->endBody() ?>

</html>

<?php $this->endPage() ?>
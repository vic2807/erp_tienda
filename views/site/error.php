<?php

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1 class="mt-5"><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger mt-5">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p class="mt-5">
        El error anterior se presentó al realziar una acción en el servidor.
    </p>
    <p class="mt-5">
        Por fvór contactanos si piensas que esto es un error del servidor, gracias.
    </p>

</div>
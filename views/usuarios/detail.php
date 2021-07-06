<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="mod-usuarios-ent-usuarios-view body-content">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar usuario', ['update', 'id' => $model->id_usuario], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar usuario', ['delete', 'id' => $model->id_usuario], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'txt_username',
            'txt_apellido_paterno',
            'txt_apellido_materno',
            'txt_email:email',
            'txt_password',
            
            // 'txt_token',
            // 'txt_auth_key',
            // 'txt_password_hash',
            // 'txt_password_reset_token',
            
        ],
    ]) ?>

</div>
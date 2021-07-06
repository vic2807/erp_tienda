<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Usuarios del sistema';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mod-usuarios-ent-usuarios-index body-content">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Agregar usuario nuevo', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id_usuario',
            //'txt_token',
            //'txt_imagen',
            'nombreCompleto',
            //'txt_auth_key',
            //'txt_password_hash',
            //'txt_password_reset_token',
            'txt_email:email',
            //'txt_password',


            [
                'label' => 'Estatus',
                'format' => 'ntext',
                'attribute' => 'id_status',
                'value' => function ($model) {
                    return $model->status->txt_nombre;
                },
            ],

            [
                'label' => 'Rol',
                'format' => 'ntext',
                'attribute' => 'id_rol_usuario',
                'value' => function ($model) {
                    return $model->rolUsuario->txt_nombre;
                },
            ],
            'fch_creacion',
            'fch_actualizacion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
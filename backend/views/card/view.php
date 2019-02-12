<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Cart */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="x_panel">
    <div class="x_title">
        <h2><?= $this->title?></h2>
        &nbsp; &nbsp;
        <?//= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить заказ', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="card-view">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'total_sum',
                    'total_qty',
                    [
                        'attribute' => 'id_user',
                        'value' => $model->user->email
                    ],
                    [
                        'attribute' => 'id_manager',
                        'value' => $model->user->email
                    ],
                    [
                        'attribute' => 'id_tranpor',
                        'value' => $model->user->email
                    ],
//            'id_manager',
//            'id_tranpor',
                    //'id_status',
                    [
                        'attribute' => 'id_status',
                        'value' => $model->status->name
                    ],
                    'created_at',
                    'updated_at',
                ],
            ]) ?>

        </div>
    </div>
</div>

<div class="x_panel">
    <div class="x_title">
        <h2>Заказы</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',
                [
                    'attribute' => 'фотография',
                    'value' => function ($data) {
                        return Html::img('/uploads/' . $data->menu->img, ['height' => 100]);
                    },
                    'format' => 'html'
                ],
                [
                    'attribute' => 'id_menu',
                    'value' => function ($data) {
                        return $data->menu->name;
                    }
                ],
                'qty',
                'price',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>





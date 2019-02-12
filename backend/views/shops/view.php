<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Shops */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="x_panel">
    <div class="x_title">
        <h2 class="pull-left"><?= $this->title?></h2>
        <p class="pull-right">
            <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="shops-view">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'id_manager',
                    'name',
                    'tr_name',
                    [
                        'attribute' => 'logo',
                        'value' => Html::img(Yii::$app->params['linkSite'] . Yii::$app->params['restaurantImagePath'] . $model->logo, ['width' => 150]),
                        'format' => 'html',
                    ],
                    'created_at',
                    'updated_at',
                    [
                        'attribute' => 'address',
                        'value' => $model->country->name . ', '. $model->region->name . ', ' .$model->city->name . ', ' . $model->address,
                        'format' => 'html',
                    ],
                    //'address',
                    'phone',
                    'email',
                    [
                        'attribute' => 'published',
                        'value' => $model->published ? 'Опубликован' : 'Не опубликован',
                        'contentOptions' => ['class' => \common\component\Constatnts::COLOR_PUBLISH[(int)($model->published)]['class']],
                        'format' => 'html'
                    ]
                ],
            ]) ?>

        </div>
    </div>
</div>
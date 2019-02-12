<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Menu */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="x_panel">
    <div class="x_title">
        <h2 class="pull-left"><?= $this->title?> </h2>
        <div class="pull-right">
            <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="menu-view">
            <p>

            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    [
                        'attribute' => 'img',
                        'value' => Html::img(Yii::$app->params['linkSite'] . Yii::$app->params['menuImagePath'] . $model->img, ['width' => 150]),
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'id_shop',
                        'value' => Html::a($model->shop->name, ['shops/view', 'id' => $model->id_shop]),
                        'format' => 'html'
                    ],
                    'desc',
                    'ingredients',
                    'created_at',
                    'updated_at',
                ],
            ]) ?>

        </div>
    </div>
</div>




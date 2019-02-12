<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SearchMenu */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Меню';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="x_panel">
    <div class="x_title">
        <h2 class="pull-left"><?= $this->title?></h2>
        <?= Html::a('Добавить меню', ['create'], ['class' => 'btn btn-success btn-sm pull-right']) ?>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="menu-index">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'img',
                        'filter' => false,
                        'value' => function ($data) {
                            return Html::img(Yii::$app->params['linkSite'] . Yii::$app->params['menuImagePath']. $data->img, ['height' => 100]);
                        },
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'id_cat',
                        'value' => function ($data) {
                            return $data->category->name;
                        }
                    ],
                    'name',
                    [
                        'attribute' => 'id_shop',
                        'value' => function ($data) {
                            return Html::a($data->shop->name, ['shops/view', 'id' => $data->id_shop]);
                        },
                        'format' => 'html'
                    ],
                    //'portion',
                    'created_at',
                    //'updated_at',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>



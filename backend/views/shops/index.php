<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SearchShops */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рестораны';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="x_panel">
    <div class="x_title">
        <h2 class="pull-left"><?= $this->title?></h2>
        <?= Html::a('Добавить ресторан', ['create'], ['class' => 'btn btn-success btn-sm pull-right']) ?>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="shops-index">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'logo',
                        'format' => 'html',
                        'filter' => false,
                        'value' => function ($data) {
                            return Html::img(Yii::$app->params['linkSite'] . Yii::$app->params['restaurantImagePath'] . $data->logo, ['width' => 100]);
                        }
                    ],
                    'name',
                    [
                        'attribute' => 'id_manager',
                        'value' => function ($data) {
                            return $data->manager->email;
                        }
                    ],
                    'created_at',
                    [
                        'attribute' => 'published',
                        'value' => function ($data) {
                            return $data->published ? 'Опубликован' : 'Не опубликован';
                        },
                        'contentOptions'=>function ($model, $key, $index, $column){
                            return ['class' => \common\component\Constatnts::COLOR_PUBLISH[(int)($model->published)]['class']];
                        },
                        'format' => 'html'
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>



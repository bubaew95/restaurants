<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SliderImgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Слайдер';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="x_panel">
    <div class="x_title">
        <h2 class="pull-left"><?= $this->title?></h2>
        <?= Html::a('Добавить новый слайдер', ['create'], ['class' => 'btn btn-success btn-sm pull-right']) ?>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="slider-img-index">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    [
                        'attribute' => 'image',
                        'filter' => false,
                        'value' => function ($data) {
                            return Html::img(Yii::$app->params['linkSite'] . Yii::$app->params['sliderImagePath']. $data->image, ['width' => 200]);
                        },
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'id_shop',
                        'value' => function ($data) {
                            return Html::a($data->shop->name, ['shops/view', 'id' => $data->id_shop]);
                        },
                        'format' => 'html'
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>

    </div>
</div>


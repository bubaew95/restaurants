<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SearchCart */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="x_panel">
    <div class="x_title">
        <h2><?= Html::encode($this->title) ?></h2>
        &nbsp; &nbsp;
        <?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="card-index">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    [
                        'attribute' => 'id_user',
                        'value' => function ($data) {
                            return $data->user->email;
                        }
                    ],
                    //'id_shop',
                    [
                        'attribute' => 'id_shop',
                        'value' => function ($data) {
                            return $data->shop->name;
                        }
                    ],
                    [
                        'attribute' => 'total_sum',
                        'value' => function ($data) {
                            return $data->total_sum . " руб.";
                        }
                    ],
                    'total_qty',
                    //'id_tranpor',
                    [
                        'attribute' => 'id_status',
                        'value' => function ($data) {
                            return $data->status->name;
                        }
                    ],
                    //'created_at',
                    //'updated_at',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>



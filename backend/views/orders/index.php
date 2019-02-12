<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SearchOrders */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="x_panel">
    <div class="x_title">
        <h2 class="pull-left">
            <?= $this->title?>

        </h2>
        <?php if(Yii::$app->user->can(\common\component\Constatnts::RBACK_ADMIN)) : ?>
            &nbsp;
            <?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success btn-sm pull-right']) ?>
        <?php endif ?>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="orders-index">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php

                $template = '{view}';
                if(Yii::$app->user->can(\common\component\Constatnts::RBACK_ADMIN)) {
                    $template = '{view} {update} {delete}';
                }

            ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    [
                        'attribute' => 'id_user',
                        'value' => function ($data) {
                            return $data->user->userinfo->fio;
                        }
                    ],
        //            [
        //                'attribute' => 'id_menu',
        //                'value' => function ($data) {
        //                    return $data->menu->name;
        //                }
        //            ],
                    //'id_card',
                    [
                        'attribute' => 'id_shop',
                        'value' => function ($data) {
                            return $data->shop->name;
                        }
                    ],
                    'qty',
                    'price',
                    [
                        'attribute' => 'allprice',
                        'value' => function ($data) {
                            return ($data->price * $data->qty);
                        }
                    ],
                    [
                        'attribute' => 'id_transport',
                        'value' => function ($data) {
                            return $data->id_transport ? $data->user->username : 'Заказ пока не принят курьером';
                        },
                        'contentOptions'=>function ($model, $key, $index, $column){
                            $num = $model->id_transport ? 5 : 6;
                            return ['class' => \common\component\Constatnts::COLOR_STATUS[(int)$num]['class']];
                        },
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'id_status',
                        'value' => function ($data) {
                            return $data->status->name;
                        },
                        'contentOptions'=>function ($model, $key, $index, $column){
                            return ['class' => \common\component\Constatnts::COLOR_STATUS[(int)($model->id_status)]['class']];
                        },
                        'format' => 'html'
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => $template,
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
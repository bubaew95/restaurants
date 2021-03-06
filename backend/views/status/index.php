<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\StatusCategories */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статус заказа';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="x_panel">
    <div class="x_title">
        <h2 class="pull-left"><?= $this->title?></h2>
        <?= Html::a('Добавить статус', ['create'], ['class' => 'btn btn-success btn-sm pull-right']) ?>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="status-index">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    'name',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>



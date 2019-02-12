<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\component\Constatnts;

/* @var $this yii\web\View */
/* @var $model common\models\Orders */


$this->title = $model->menu->name;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="x_panel">
    <div class="x_title">
        <h2><?= $this->title?></h2>
        <div class="pull-right">
            <?php if(Yii::$app->user->can(Constatnts::RBACK_ADMIN)) : ?>
                <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger  btn-sm',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif ?>
            <?php if(Yii::$app->user->can(Constatnts::RBACK_TRANSPORT) && $model->id_transport == null) : ?>
                <?= Html::a('Принять заказ',
                    ['receive', 'id' => $model->id],
                    ['class' => 'btn btn-warning btn-sm', 'id' => 'take_an_order']
                ) ?>
            <?php endif ?>
        </div>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="orders-view">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'id_user',
                        'value' => $model->user->username,
                    ],
                    [
                        'attribute' => 'id_menu',
                        'value' => $model->menu->name,
                    ],
                    //'id_card',
                    [
                        'attribute' => 'id_shop',
                        'value' => $model->shop->name,
                    ],
                    [
                        'attribute' => 'id_status',
                        'value' => $model->status->name,
                        'contentOptions'=>  ['class' => \common\component\Constatnts::COLOR_STATUS[ (int) $model->id_status]['class']],
                    ],
                    [
                        'attribute' => 'id_transport',
                        'value' => $model->id_transport != null ? 'Заказ принят курьером: <b>'.$model->user->username .'</b>' : 'Пока не определен',
                        'contentOptions'=>  ['class' => \common\component\Constatnts::COLOR_STATUS[ $model->id_transport != null ? 5 : 2]['class']],
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'address',
                        'value' => $model->user->email
                    ],
                    'qty',
                    [
                        'attribute' => 'price',
                        'value' => $model->price . ' руб.'
                    ],
                    [
                        'attribute' => 'allprice',
                        'value' => '<strong>'. ($model->qty * $model->price) . ' руб.<strong>',
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'id_address_delivery',
                        'value' => $model->addressDelivery ? $model->addressDelivery->country->name . ',' .
                                    $model->addressDelivery->region->name . ',' .
                                    $model->addressDelivery->city->name . ',' .
                                    $model->addressDelivery->address : '<i class="text-danger">Адрес доставки не найден</i>',
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'id_delivery',
                        'value' => $model->delivery->name,
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'created_at',
                        'value' => Yii::$app->formatter->asDatetime($model->created_at),
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'updated_at',
                        'value' => Yii::$app->formatter->asDatetime($model->updated_at),
                        'format' => 'html'
                    ]
                ],
            ]) ?>

        </div>

    </div>
</div>

<?php

$js = <<<JS

    $(document).on('click', '#take_an_order', function(e) {
         e.preventDefault();
         $.get({
            url : $(this).attr('href'),
            dataType: 'json',
            success: function (data) {
                alert(data.msg);
                if(data.code == 200) {
                    window.location.reload();
                }
            },
            error: function (s, m, e) {
                console.log(s, m, e);
            }
         });
    });

JS;

$this->registerJs($js);

?>

<div class="x_panel">
    <div class="x_title">
        <h2>Карта</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
    </div>
</div>



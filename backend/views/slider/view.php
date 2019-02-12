<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\SliderImg */

$this->title = 'Слайдер - ' . $model->shop->name;
$this->params['breadcrumbs'][] = ['label' => 'Слайдер', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$idSlider = $model->id ?? 0;
?>

<div class="x_panel">
    <div class="x_title">
        <h2>
            <?= $this->title?>
            <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="slider-img-view">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'image',
                        'value' => Html::img(Yii::$app->params['linkSite'] . Yii::$app->params['sliderImagePath']. $model->image, ['width' => 200]),
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'id_shop',
                        'value' => $model->shop->name,
                        'format' => 'html'
                    ],
                ],
            ]) ?>

        </div>
    </div>
</div>

<div class="x_panel">
    <div class="x_title">
        <h2>
            Информация в слайдере
            <button id="addItems" data-id="<?= $model->id ?>" class="btn btn-warning btn-sm" >Добавить</button>
        </h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php \yii\widgets\Pjax::begin(); ?>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',
                //'id_slider',
                [
                    'attribute' => 'blob',
                    'value' => function($data) {
                        return ($data->blob);
                    },
                    'format' => 'html',
                    'contentOptions' => [
                        'style'=>'max-width:150px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],
               // 'classes',
                //'type',
                //'data_x',
                //'data_y',
                //'data_splitin',
                //'data_splitout',
                //'data_elementdelay',
                //'data_start',
                //'data_speed',
                //'data_easing',
                //'data_customin',
                //'data_customout',
                //'data_endspeed',
                //'data_endeasing',
                //'data_captionhidden',
                //'style',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url,$model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-pencil"></span>', [], ['class' => 'edit-item', 'data-id_slider' => $model->id_slider, 'data-id' => $model->id]);
                        },
                        'delete' => function ($url,$model,$key) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-trash"></span>', [], ['class' => 'delete-item', 'data-id' => $model->id]);
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php \yii\widgets\Pjax::end(); ?>
    </div>
</div>
<?php
$urlCreate = \yii\helpers\Url::to(['slideritems/create-items']);
$urlUpdate = \yii\helpers\Url::to(['slideritems/update-items']);
$urlDelete = \yii\helpers\Url::to(['slideritems/delete-items']);
$js = <<<JS
    $('#addItems').on('click', function () {
       var id = $(this).data('id');
       $.get({
            url: '$urlCreate',
            dataType:'html',
            data: {id:id},
            success: function (data) { 
                $('#modalWindow .modal-body').empty().append(data);
                $('#modalWindow').modal('show');
            }
       }); 
    });
    $('.edit-item').on('click', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var id_slider = $(this).data('id_slider');
       $.get({
            url: '$urlUpdate',
            dataType:'html',
            data: {id:id, id_slider:id_slider},
            success: function (data) { 
                $('#modalWindow .modal-body').empty().append(data);
                $('#modalWindow').modal('show');
            }
       }); 
    });
    
    $('.delete-item').on('click', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.get({
            url: '$urlDelete',
            dataType:'json',
            data: {id:id},
            success: function (data) { 
                if(data.code == 200) {
                    window.location.reload();
                }
            }
        }); 
    });
    
    $(document).on('click', '#btn-add', function() { 
        $(this).yiiActiveForm('validate', true);
        return false;
    })
    .on('submit','#add-item-slider-form',function() {
        return false;
    })
    .on('afterValidate','#add-item-slider-form', function (event, attribute, messages) {
        var serialize = $(this).serialize();
        var url = $(this).attr('action');
        $.post({
            url: url,
            data: serialize, 
            dataType: 'json', 
            success: function(data) {
                console.log(data);
                if(data.code == 200) {
                    window.location.reload();
                }
            }
        }).fail(function() {
            alert( "error" );
        });  
        return false;
    });
    
JS;
$this->registerJs($js);
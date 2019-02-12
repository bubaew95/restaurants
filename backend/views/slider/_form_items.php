<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\SliderText */
/* @var $form yii\widgets\ActiveForm */
$dataClass = [
    'Фон' => [
        'largeblackbg'                  => 'Черный фон',
        'br-yellow'                     => 'Желтый фон',
        'white'                         => 'Белый цвет',
        'thinheadline_dark'             => 'Черный цвет',
        'br-red'                        => 'Красный фон',
        'br-green'                      => 'Зеленый фон',
        'br-orange'                     => 'Оранжевый фон',
        'br-purple'                     => 'Фиолетовый фон',
        'medium_bg_darkblue'            => 'Темно-синий фон',
        'br-lblue'                      => 'Светло-синий фон',
        'medium_text'                   => 'Жирный белый цвет',
        'finewide_medium_white'         => 'Средний, белый цвет',
        'modern_big_redbg'              => 'Средний, красный фон',
        'modern_medium_light'           => 'Средний, черный цвет',
        'heading'                       => 'Заголовок красный цвет',
        'largepinkbg'                   => 'Больщой шр. розовый фон',
        'large_bold_grey'               => 'Больщой, жирный, серый цвет',
        'finewide_verysmall_white_mw'   => 'Маленький, широкий, белый цвет',
    ],

    'Эффекты' => [
        'customin'                      => 'Эффект открытия',
        'customout'                     => 'Эффект закрытия',
        'randomrotate'                  => 'Случайный эффект',
        'lfl'                           => 'Эффект появления слева',
        'sfl'                           => 'Эффект появления слева',
        'sfb'                           => 'Эффект появления снизу',
        'skewfromright'                 => 'Эффект появления справа',
        'tp-resizeme'                   => 'Эффект медленного появления',
        'start'                         => 'Эффект замедленного появления',
        'splitted'                      => 'Эффект замедленного появления',
    ],

    'Прочие' => [
        'paragraph'                     => 'Параграф',
        'text-right'                    => 'Текст справа',
        'whitedivider3px'               => 'Белая линиия'
    ]
];
?>

<div class="slider-text-form">
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['options' => ['id' => 'add-item-slider-form']]); ?>

            <div class="row">

                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'type')->dropDownList([
                                0 => 'Текст',
                                1 => 'Изображение',
                            ]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'blob')->textarea(['maxlength' => true, 'placeholder' => 'Введите текст']) ?>
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <?php
                        if($model->classes) {
                            $exp = $model->getClasses();
                            $arr = [];
                            foreach ($exp as $v) {
                                $arr[$v] = $v;
                            }
                            $model->classes = $arr;
                        }
                    ?>
                    <?= $form->field($model, 'classes')->widget(Select2::classname(), [
                        'data' => $dataClass,
                        'options' => ['placeholder' => 'Выбрать стиль', 'multiple' => true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
                </div>

                <div class="col-md-4">

                    <?= $form->field($model, 'style')->textInput(['maxlength' => true, 'placeholder' => 'z-index: 1;']) ?>

                    <?= $form->field($model, 'data_x')->textInput(['placeholder' => 0]) ?>

                    <?= $form->field($model, 'data_y')->textInput(['placeholder' => 0]) ?>

                    <?= $form->field($model, 'data_splitin')->dropDownList([
                        '' => 'Не выбан',
                        'chars' => 'chars',
                        'lines'
                    ]) ?>

                    <?= $form->field($model, 'data_splitout')->dropDownList([
                        '' => 'Не выбан',
                        'chars' => 'chars',
                        'lines'
                    ]) ?>
                </div>
                <div class="col-md-4">


                    <?= $form->field($model, 'data_elementdelay')->textInput(['placeholder' => 0.00]) ?>

                    <?= $form->field($model, 'data_start')->textInput(['placeholder' => 1000]) ?>

                    <?= $form->field($model, 'data_speed')->textInput(['placeholder' => 600]) ?>

                    <?= $form->field($model, 'data_easing')->dropDownList([
                            '' => 'Не выбран',
                        'Back.easeOut' => 'Back.easeOut',
                        'Power3.easeInOut' => 'Power3.easeInOut',
                        'Power4.easeOut' => 'Power4.easeOut',
                        'Power4.easeIn' => 'Power4.easeIn',
                    ]) ?>

                    <?= $form->field($model, 'data_captionhidden')->dropDownList([
                            '' => 'Не выбран',
                            'off' => 'off',
                            'off' => 'off',
                    ]) ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'data_customin')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:0% 0%;',
                    ]) ?>

                    <?= $form->field($model, 'data_customout')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:0% 0%;',
                    ]) ?>

                    <?= $form->field($model, 'data_endspeed')->textInput(['placeholder' => 500]) ?>

                    <?= $form->field($model, 'data_endeasing')->dropDownList([
                        '' => 'Не выбран',
                        'Back.easeOut' => 'Back.easeOut',
                        'Power3.easeInOut' => 'Power3.easeInOut',
                        'Power4.easeOut' => 'Power4.easeOut',
                        'Power4.easeIn' => 'Power4.easeIn',
                    ]) ?>
                </div>
            </div>


            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success pull-right', 'id' => 'btn-add']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
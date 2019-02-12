<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Shops;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\SliderImg */
/* @var $form yii\widgets\ActiveForm */

$arrayShops = $arrayShops?:ArrayHelper::map(Shops::find()->where(['id_manager' => Yii::$app->user->identity->getId()])->asArray()->all(), 'id', 'name');
?>

<div class="row">
    <div class="col-md-6">

        <div class="x_panel">
            <div class="x_title">
                <h2><?= $this->title?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="slider-img-form">
                    <?php if($model->errors) debug($model->errors) ; ?>
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'id_shop')->widget(Select2::classname(), [
                                'data' => $arrayShops,
                                'language' => 'ru',
                                'options' =>
                                    [
                                        'id' => 'id_region',
                                        'disabled' => !$model->isNewRecord || count($arrayShops) == 0,
                                        'placeholder' => "Выберите ресторан",
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'image')->fileInput() ?>
                            <?= Html::hiddenInput('SliderImg[img]', $model->image); ?>
                        </div>
                    </div>

                    <hr >
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-success btn-sm pull-right']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>

    </div>
</div>
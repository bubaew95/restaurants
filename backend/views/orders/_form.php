<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Orders */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="x_panel">
    <div class="x_title">
        <h2><?= $this->title?></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="orders-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'id_menu')->textInput() ?>

            <?= $form->field($model, 'qty')->textInput() ?>

            <?= $form->field($model, 'id_shop')->textInput() ?>

            <?= $form->field($model, 'id_status')->textInput() ?>

            <?= $form->field($model, 'id_transport')->textInput() ?>

            <?= $form->field($model, 'price')->textInput() ?>

            <?= $form->field($model, 'id_user')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
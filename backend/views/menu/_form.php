<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Shops;
use mihaildev\ckeditor\CKEditor;


/* @var $this yii\web\View */
/* @var $model common\models\Menu */
/* @var $form yii\widgets\ActiveForm */

$arrayShops = $arrayShops?:ArrayHelper::map(Shops::find()->where(['id_manager' => Yii::$app->user->identity->getId()])->asArray()->all(), 'id', 'name');
$arrayCat = $arrayCat?:ArrayHelper::map(\common\models\Categories::find()->asArray()->all(), 'id', 'name');

?>

<div class="x_panel">
    <div class="x_title">
        <h2><?= $this->title?></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="menu-form">

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'desc')->widget(CKEditor::className(),[
                        'editorOptions' => [
                            'preset' => 'standard', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                            'inline' => false, //по умолчанию false
                        ],
                    ])?>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'id_shop')->widget(Select2::classname(), [
                        'data' => $arrayShops,
                        'language' => 'ru',
                        'options' =>
                            [
                                'id' => 'id_region',
                                'disabled' => count($arrayShops) == 0,
                                'placeholder' => "Выберите ресторан",
                            ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
                    ?>



                    <?= $form->field($model, 'ingredients')->widget(CKEditor::className(),[
                        'editorOptions' => [
                            'preset' => 'basic', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                            'inline' => false, //по умолчанию false
                        ],
                    ]) ?>

                    <?= $form->field($model, 'id_cat')->dropDownList($arrayCat) ?>

                    <?= $form->field($model, 'isToday')->dropDownList([
                        0 => 'Нет',
                        1 => 'Да'
                    ]) ?>

                    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'img')->fileInput() ?>

                    <!--    --><?//= $form->field($model, 'updated_at')->textInput([
                    //            'placeholder' => 'Дата ставится по умолчанию'
                    //    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success pull-right']) ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>



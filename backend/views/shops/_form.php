<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
$arrayCountry = $arrayCountry?:\yii\helpers\ArrayHelper::map(\common\models\LocationCountries::find()->asArray()->all(), 'id_country', 'name');
$arrayRegions = $arrayRegions?:\yii\helpers\ArrayHelper::map(\common\models\LocationRegions::find()->asArray()->all(), 'id_region', 'name');
$arrayCities = $arrayCities?:\yii\helpers\ArrayHelper::map(\common\models\LocationCities::find()->asArray()->all(), 'id_cities', 'name');
$arrayManager = $arrayManager?:\yii\helpers\ArrayHelper::map(\common\models\User::find()->where(['!=', 'password_hash', ''])->asArray()->all(), 'id', 'email');

/* @var $this yii\web\View */
/* @var $model common\models\Shops */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="x_panel">
    <div class="x_title">
        <h2><?= $this->title?></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="shops-form">

            <?php $form = ActiveForm::begin(); ?>

                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <?= $form->field($model, 'tr_name')->textInput(['maxlength' => true, 'placeholder' => 'Алиас заполняется автоматически']) ?>
                        </div>
                    </div>
                    <?= $form->field($model, 'description')->widget(CKEditor::className(),[
                        'editorOptions' => [
                            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                            'inline' => false, //по умолчанию false
                        ],
                    ]) ?>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">

                    <?php if( Yii::$app->user->can(\common\component\Constatnts::RBACK_ADMIN) ): ?>
                        <?= $form->field($model, 'id_manager')->widget(Select2::classname(), [
                                'data' => $arrayManager,
                                'language' => 'ru',
                                'options' =>
                                    [
                                        'id' => 'id_manager',
                                        'disabled' => count($arrayManager) == 0,
                                        'placeholder' => "Выберите менеджера",
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]);
                        ?>
                    <?php endif ?>

                    <?= $form->field($model, 'id_country')->widget(Select2::classname(), [
                            'data' => $arrayCountry,
                            'language' => 'ru',
                            'options' =>
                                [
                                    'id' => 'id_country',
                                    'disabled' => count($arrayCountry) == 0,
                                    'placeholder' => "Выберите страну",
                                ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ]
                        ]);
                    ?>

                    <?= $form->field($model, 'id_region')->widget(Select2::classname(), [
                        'data' => $arrayRegions,
                        'language' => 'ru',
                        'options' =>
                            [
                                'id' => 'id_region',
                                'disabled' => count($arrayRegions) == 0,
                                'placeholder' => "Выберите страну",
                            ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
                    ?>

                    <?= $form->field($model, 'id_city')->widget(Select2::classname(), [
                        'data' => $arrayCities,
                        'language' => 'ru',
                        'options' =>
                            [
                                'id' => 'id_city',
                                'disabled' => count($arrayCities) == 0,
                                'placeholder' => "Выберите страну",
                            ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
                    ?>

                    <?= $form->field($model, 'address')->textarea() ?>

                    <?= $form->field($model, 'index')->textInput() ?>

                    <?= $form->field($model, 'phone')->textInput() ?>

                    <?= $form->field($model, 'email')->textInput() ?>

                    <?= Html::hiddenInput('Shops[img_logo]', $model->logo); ?>

                    <?= $form->field($model, 'logo')->fileInput() ?>

                    <?= $form->field($model, 'published')->dropDownList([
                        0 => 'Не опубликован',
                        1 => 'Опубликован',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-success btn-sm pull-right']) ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

            <?//= $form->field($model, 'id_manager')->textInput() ?>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

<?php
$regionUrl = \yii\helpers\Url::to(['json/regions']);
$cityUrl = \yii\helpers\Url::to(['json/cities']);

$js = <<<JS
    $('#id_region').prop('disabled', true);
    $('#id_city').prop('disabled', true);
    var CODE = {
        SelectRegion: function () {
            $('#id_country').on('change', function (e) {
                $('#id_region').prop('disabled', true);
                $('#id_city').prop('disabled', true);
                var id = $(this).val(); 
                $.ajax({
                    url: '$regionUrl',
                    data: {id_country:id},
                    type: 'POST',
                    success: function(data) {
                        $('#id_region').empty().append(data);
                    },
                    complete: function () {
                        $('#id_region').prop('disabled', false);
                    }
                });
            });
        },
        SelectCity: function () {
            $('#id_region').on('change', function (e) {
                $('#id_city').prop('disabled', true);
                var id = $(this).val(); 
                $.ajax({
                    url: '$cityUrl',
                    data: {id_region:id},
                    type: 'POST',
                    success: function(data) {
                        $('#id_city').empty().append(data);
                    },
                    complete: function () {
                        $('#id_city').prop('disabled', false);
                    }
                });
            });
        },
        Init: function () {
            this.SelectRegion();
            this.SelectCity();
        }
    
    };
    CODE.Init();

    
JS;

$this->registerJs($js);

?>



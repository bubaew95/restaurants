<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Orders */
/* @var $form yii\widgets\ActiveForm */
$arrayCountry = $arrayCountry?:\yii\helpers\ArrayHelper::map(\common\models\LocationCountries::find()->asArray()->all(), 'id_country', 'name');
$arrayRegions = $arrayRegions?:\yii\helpers\ArrayHelper::map(\common\models\LocationRegions::find()->asArray()->all(), 'id_region', 'name');
$arrayCities = $arrayCities?:\yii\helpers\ArrayHelper::map(\common\models\LocationCities::find()->asArray()->all(), 'id_cities', 'name');

?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelUserData, 'fio')->textInput() ?>

    <?= $form->field($modelUserData, 'birthday')->textInput() ?>

    <?= $form->field($modelUser, 'email')->textInput() ?>

    <?= $form->field($modelUserData, 'phone')->textInput() ?>

    <?= $form->field($modelAddress, 'id_country')->widget(Select2::classname(), [
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

    <?= $form->field($modelAddress, 'id_region')->widget(Select2::classname(), [
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

    <?= $form->field($modelAddress, 'id_city')->widget(Select2::classname(), [
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

    <?= $form->field($modelAddress, 'address')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$regionUrl = \yii\helpers\Url::to(['json/regions']);
$cityUrl = \yii\helpers\Url::to(['json/cities']);

$js = <<<JS
    
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

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SliderImg */

$this->title = 'Добавление нового слайдер';
$this->params['breadcrumbs'][] = ['label' => 'Слайдер', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-img-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SliderImg */

$this->title = 'Update Slider Img: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Slider Imgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="slider-img-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

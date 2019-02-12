<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Shops */

$this->title = 'Редактировать ресторан: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Рестораны', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="shops-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

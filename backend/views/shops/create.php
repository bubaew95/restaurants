<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Shops */

$this->title = 'Добавить ресторан';
$this->params['breadcrumbs'][] = ['label' => 'Рестораны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shops-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

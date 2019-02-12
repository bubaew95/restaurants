<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Composition */

$this->title = 'Create Composition';
$this->params['breadcrumbs'][] = ['label' => 'Compositions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="composition-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

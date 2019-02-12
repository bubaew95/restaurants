<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
$css = <<<CSS
.checkbox {
    float:left;
}
.float-right {
    float: right;
}
CSS;
$this->registerCss($css);
?>
<div class="login_wrapper">
    <div class="animate form login_form">
        <section class="login_content">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <h1>Login Form</h1>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(false) ?>
                <?= $form->field($model, 'password')->passwordInput()->label(false)?>
                <div class="form-group">
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    <?= Html::submitButton('Log in', ['class' => 'btn btn-default submit float-right', 'name' => 'login-button']) ?>
                </div>
                <div class="clearfix"></div>

                <div class="separator">
                    <div class="clearfix"></div>
                    <br>
                    <div>
                        <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                        <p>©<?= date('Y')?> All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>

        </section>
    </div>
</div>
<?php
use yii\widgets\Breadcrumbs;
use yiister\gentelella\widgets\FlashAlert;
use yii\bootstrap\Modal;
/**
 * Created by PhpStorm.
 * user: BorzStd
 * Date: 25.06.2018
 * Time: 17:23
 */
?>
<!-- page content -->
<div class="right_col" role="main">
    <?php if (isset($this->blocks['content-header'])) { ?>
        <h1><?= $this->blocks['content-header'] ?></h1>
    <?php } else { ?>
        <h1>
            <?php
            if ($this->title !== null) {
                //echo \yii\helpers\Html::encode($this->title);
            }?>
        </h1>
    <?php } ?>

    <?= Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])
    ?>

    <?= FlashAlert::widget() ?>

    <div class="clearfix"></div>

    <?= $content ?>
</div>
<!-- /page content -->
<!-- footer content -->
<footer>
    <div class="pull-right">
        Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com" rel="nofollow" target="_blank">Colorlib</a><br />
        Extension for Yii framework 2 by <a href="http://yiister.ru" rel="nofollow" target="_blank">Yiister</a>
    </div>
    <div class="clearfix"></div>
</footer>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>

<?php
Modal::begin([
    'header' => '<h2></h2>',
    'id' => 'modalWindow',
]);

Modal::end();
<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */
use yii\helpers\Html;
use backend\assets\AppAsset;
use yii\bootstrap\Modal;

AppAsset::register($this);
$bundle = yiister\gentelella\assets\Asset::register($this);

if (Yii::$app->controller->action->id === 'login') {
    echo $this->render(
        'main-login',
        ['content' => $content, 'bundle' => $bundle]
    );
} else {

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>" >
<?php $this->beginBody(); ?>

<div class="container body">
    <div class="main_container">
        <div class="wrapper">

            <?= $this->render(
                'header.php',
                ['bundleAsset' => $bundle]
            ) ?>

            <?= $this->render(
                'left.php',
                ['bundleAsset' => $bundle]
            )
            ?>

            <?= $this->render(
                'content.php',
                ['content' => $content]
            ) ?>

        </div>
    </div>
</div>
<?php

Modal::begin([
    'header' => '<h2></h2>',
    'id' => 'modalwindow',
    'footer' => '<div class="clearfix"></div>',
]);

Modal::end();

?>
<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
<?php } ?>
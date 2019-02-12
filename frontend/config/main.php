<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'language' => 'ru_RU',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'loginUrl' => ['/login']
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'r/<alias:[0-9a-zA-Z_-]+>' => 'restaurants/view',
                'r/<alias:[0-9a-zA-Z_-]+>/<id_cat:[0-9]+>' => 'restaurants/view',
                'menu/<id_cat:[0-9]+>' => 'menu/index',
                'cart' => 'cart/index',
                'menu/<alias:[0-9a-zA-Z_-]+>/<id:[0-9]+>' => 'menu/view',
                'a/<alias:[0-9a-zA-Z_-]+>' => 'restaurants/open',
                'page/<alias:[0-9a-zA-Z_-]+>' => 'page/view',
                //'restaurant/contact' => 'restaurants/contacts',
                //'http://api.restaurant/region/<id_country:[0-9]+>'  => "region/index",
            ],
        ],
        'assetManager' => [
            'bundles' => [
//                'yii\web\JqueryAsset' => [
//                    'js'=>[]
//                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
    ],
//    'modules' => [
//        'api' => [
//            'class' => 'frontend\modules\v1\Api',
//        ],
//    ],
    'params' => $params,
];

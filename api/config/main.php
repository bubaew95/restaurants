<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'sourceLanguage' => 'en_US',
    'language' => 'ru',
    'charset' => 'utf-8',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
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
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'enableCsrfCookie' => false,
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'format'=>\yii\web\Response::FORMAT_JSON,
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['country','user', 'restaurant'],
                    'extraPatterns' => [
                        'GET country' => 'country',
                    ],
                ],
                'POST region' => 'region/index',
                'POST city' => 'city/index',
                'POST restdishes' => 'restdishes/index',
                'POST restdishes/likedishes' => 'restdishes/likedishes',
                'POST comments' => 'comment/index',
                'POST comments/create' => 'comment/create',
                'POST checkorder/create' => 'checkorder/create',
                'GET order' => 'order/index',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['menu', 'delivery', 'user-address', 'restmenu'],
                    'except' => ['delete'],
                ],
            ],
        ],
        'as authenticator' => [
            'class' => 'yii\filters\auth\CompositeAuth',
            'except' => [
                'order/index',
            ],
            'authMethods' => [
                ['class' => 'yii\filters\auth\HttpBearerAuth'],
                ['class' => 'yii\filters\auth\QueryParamAuth','tokenParam' => 'accessToken']
            ],
        ],
        'as access' => [
            'class' => 'yii\filters\AccessControl',
            'except' => [
                'comment/index',
            ],
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@' ]
                ],
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];

<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            //'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            'dsn' => 'pgsql:host=localhost;port=5433;dbname=restaurant',
            'username' => 'postgres',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'br_',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];

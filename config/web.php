<?php

use yii\i18n\PhpMessageSource;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id'             => 'basic',
    'basePath'       => dirname(__DIR__),
    'bootstrap'      => ['log'],
    'language'       => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'aliases'        => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@admin' => '@app/modules/admin',
    ],
    'modules'        => [
        'admin' => [
            'class'  => 'app\modules\admin\Module',
            'layout' => 'main',
        ],
        'ckeditor' => [
            'class' => 'wadeshuler\ckeditor\Module',
        ],
    ],
    'components'     => [
        'user'         => [
            'identityClass'   => \app\modules\admin\models\User::class,
            'loginUrl'        => [],
            'enableAutoLogin' => true,
        ],
        'i18n'         => [
            'translations' => [
                'layouts' => [
                    'class'          => PhpMessageSource::class,
                    'basePath'       => '@app/messages/',
                    'sourceLanguage' => 'en-US',
                ],
                'user'    => [
                    'class'          => PhpMessageSource::class,
                    'basePath'       => '@app/messages/',
                    'sourceLanguage' => 'en-US',
                ],
                // module connect
                'admin/*' => [
                    'class'          => PhpMessageSource::class,
                    'basePath'       => '@app/messages/',
                    'sourceLanguage' => 'en-US',
                    'fileMap'        => [
                        'admin/user' => 'user.php',
                    ],
                ],
                'vote'    => [
                    'class'          => PhpMessageSource::class,
                    'basePath'       => '@app/messages/',
                    'sourceLanguage' => 'en-US',
                ],
                'email'   => [
                    'class'          => PhpMessageSource::class,
                    'basePath'       => '@app/messages/',
                    'sourceLanguage' => 'en-US',
                ],
            ],
        ],
        'authManager'  => [
            'class' => \yii\rbac\DbManager::class,
        ],
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'N8Oht1SJ-NgYHI-6T6fbAH6n4yHg_GF7',
            'baseUrl'             => '',
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            'viewPath'         => '@app/mail',
            'useFileTransport' => false,
            'transport'        => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.mail.ru',
                'username'   => 'example_dev@mail.ru',
                'password'   => 'borrow8455/Order/wet',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '<controller><action:\w+><id:\d+>' => '<controller>/<action>/<id>',
                '<controller><action:\w+><id:\d+>'         => 'admin/<controller>/<action>/<id>',
            ],
        ],

    ],
    'params'         => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        'generators' => [ // HERE
                          'crud' => [
                              'class'     => 'yii\gii\generators\crud\Generator',
                              'templates' => [
                                  'adminlte' => '@vendor/dmstr/yii2-adminlte-asset/gii/templates/crud/simple',
                              ],
                          ],
        ],
    ];
}

return $config;

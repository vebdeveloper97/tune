<?php

use app\models\User;
use app\modules\api\Module;
use yii\base\BaseObject;
use yii\web\Response;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$routers = require __DIR__ . '/routers.php';

$config = [
    'id'               => 'basic',
    'basePath'         => dirname(__DIR__),
    'bootstrap'        => ['log'],
    'language'         => 'uz-UZ',
    'aliases'          => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules'          => [
        'api'   => [
            'class' => Module::class,
        ],
        'admin' => [
            'class' => \app\modules\admin\Module::class,
        ],
        'users' => [
            'class' => 'app\modules\users\Module',
        ],
        'post'  => [
            'class' => 'app\modules\post\Module',
        ],
        'news'  => [
            'class' => 'app\modules\news\Module',
        ],
        'queue' => [
            'class' => 'app\modules\queue\Module',
        ],
    ],
    'components'       => [
        'queue'        => [
            'class'     => \yii\queue\db\Queue::class,
            'db'        => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel'   => 'default', // Queue channel key
            'mutex'     => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
        ],
        'authManager'  => [
            'class' => \yii\rbac\DbManager::class
        ],
        'request'      => [
            'cookieValidationKey' => 'FyefNhlhRIEe9Go_PMBvvpAIWbTtwSTt',
            'parsers'             => [
                'application/json' => yii\web\JsonParser::class,
            ],
        ],
        'response'     => [
            'class'         => Response::class,
            'on beforeSend' => static function ($event) {
                $response = $event->sender;
                $format = (bool)Yii::$app->request->headers['Response-Format'];

                if ($response->data !== null && $format) {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        'data'    => $response->isSuccessful ? $response->data : new BaseObject(),
                        'error'   => $response->isSuccessful ? new BaseObject() : [
                            'code'    => $response->data['status'] ?? 0,
                            'message' => $response->data['message'] ?? 'unknown error',
                        ]
                    ];
                    $response->statusCode = 200;
                }
            }
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => User::class,
            'enableAutoLogin' => false,
            'authTimeout'     => 600,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => $routers
        ],
        /*'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
        ],*/
    ],
    'params'           => $params,
    'on beforeRequest' => static function () {
        Yii::$app->params['name'] = \app\models\Post::find()->where(['status' => 1])->count();
    }
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class'      => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;

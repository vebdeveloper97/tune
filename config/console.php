<?php

use yii\console\controllers\MigrateController;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id'                  => 'basic-console',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log', 'queue'],
    'controllerNamespace' => 'app\commands',
    'aliases'             => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components'          => [
        'queue'       => [
            'class'     => \yii\queue\db\Queue::class,
            'db'        => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel'   => 'default', // Queue channel key
            'mutex'     => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
        ],
        'authManager' => [
            'class' => \yii\rbac\DbManager::class
        ],
        'cache'       => [
            'class' => 'yii\caching\FileCache',
        ],
        'log'         => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'          => $db,
    ],
    'params'              => $params,
    'controllerMap'       => [
        'migrate'       => [
            'class'         => MigrateController::class,
            'migrationPath' => [
                '@app/modules/api/migrations',
                '@yii/rbac/migrations'
            ],
        ],
        'migrate-queue' => [
            'class'               => MigrateController::class,
            'migrationPath'       => null,
            'migrationNamespaces' => ['yii\queue\db\migrations'],
        ],
        'fixture'       => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;

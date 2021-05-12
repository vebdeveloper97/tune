<?php

namespace app\modules\admin\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends AuthController
{
    public function behaviors(): array
    {
        $parent = parent::behaviors();
        $parent['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'actions' => ['index'],
                    'roles' => ['isUpdateRule'],
                    'allow' => true,
                    'roleParams' => static function () {
                        return ['post' => []];
                    }
                ],
                [
                    'allow' => true,
                    'roles' => ['admin']
                ]
            ]
        ];

        return $parent;
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTest()
    {
        echo "test";
    }
}

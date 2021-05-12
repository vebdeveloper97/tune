<?php

namespace app\modules\post\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        $parent = parent::behaviors();
        $parent['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@']
                ]
            ]
        ];
        return $parent;
    }
}

<?php

namespace app\modules\news\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `news` module
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

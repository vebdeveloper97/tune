<?php

use app\models\AuthAssignmentSearch;
use app\models\AuthItemChildSearch;
use app\models\AuthItemSearch;
use app\models\AuthRuleSearch;
use app\models\SlugRbac;
use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;
use yii\data\ActiveDataProvider;

/* @var $authItem ActiveDataProvider */
/* @var $authRule ActiveDataProvider */
/* @var $authItemChild ActiveDataProvider */
/* @var $authAssignment ActiveDataProvider */
/* @var $authItemSearch AuthItemSearch */
/* @var $authAssignmentSearch AuthAssignmentSearch */
/* @var $authItemChildSearch AuthItemChildSearch */
/* @var $authRuleSearch AuthRuleSearch */

if (Yii::$app->session->hasFlash('info')) {
    echo "<h4>" . Yii::$app->session->getFlash('info') . "</h4>";
}
echo Tabs::widget([
    'items' => [
        [
            'label'   => Yii::t('app', 'Auth Item'),
            'content' => $this->render('auth_item/item', [
                'authItem'       => $authItem,
                'authItemSearch' => $authItemSearch
            ]),
            'active'  => Yii::$app->request->get('slug') == SlugRbac::AUTH_ITEM,
            'options' => ['id' => 'auth_item']
        ],
        [
            'label'   => Yii::t('app', 'Auth Assignment'),
            'content' => $this->render('auth_assignment/item', [
                'authAssignment'       => $authAssignment,
                'authAssignmentSearch' => $authAssignmentSearch
            ]),
            'active'  => Yii::$app->request->get('slug') == SlugRbac::AUTH_ASSIGNMENT,
            'options' => ['id' => 'auth_assignment'],
        ],
        [
            'label'   => Yii::t('app', 'Auth Role'),
            'content' => $this->render('auth_rule/item', [
                'authRule'       => $authRule,
                'authRuleSearch' => $authRuleSearch
            ]),
            'active'  => Yii::$app->request->get('slug') == SlugRbac::AUTH_RULE,
            'options' => ['id' => 'auth_role'],
        ], [
            'label'   => Yii::t('app', 'Auth Item Child'),
            'content' => $this->render('auth_item_child/item', [
                'authItemChild'       => $authItemChild,
                'authItemChildSearch' => $authItemChildSearch
            ]),
            'active'  => Yii::$app->request->get('slug') == SlugRbac::AUTH_ITEM_CHILD,
            'options' => ['id' => 'auth_item_child'],
        ],
    ],
]);
?>


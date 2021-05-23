<?php

use app\models\AuthRuleSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $authRule ActiveDataProvider */
/* @var $authRuleSearch AuthRuleSearch */

$this->title = Yii::t('app', 'Auth Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-rule-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Auth Rule'), ['create', 'slug' => 'auth-rule'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $authRule,
        'filterModel'  => $authRuleSearch,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'data',
            'created_at',
            'updated_at',

            [
                'class'    => 'yii\grid\ActionColumn',
//                'template' => '{view} {update} {delete}',
//                'buttons'  => [
//                    'update' => function ($url, $model) {
//                        return Html::a(
//                            '<span class="glyphicon glyphicon-edit"></span>',
//                            ['/rbac/auth_rule/update', 'id' => $model->name]);
//                    },
//                    'delete' => function ($url, $model) {
//                        return Html::a(
//                            '<span class="glyphicon glyphicon-trash"></span>',
//                            ['/rbac/auth_rule/delete', 'id' => $model->name]);
//                    },
//                    'view'   => function ($url, $model) {
//                        return Html::a(
//                            '<span class="glyphicon glyphicon-eye-open"></span>',
//                            ['/rbac/auth_rule/view', 'id' => $model->name]);
//                    },
//
//                ]
            ],
        ],
    ]); ?>


</div>

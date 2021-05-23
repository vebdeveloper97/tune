<?php

use app\models\AuthItemChildSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $authItemChild ActiveDataProvider */
/* @var $authItemChildSearch AuthItemChildSearch */

$this->title = Yii::t('app', 'Auth Item Children');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-child-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Auth Item Child'), ['create', 'slug' => 'auth-item-child'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $authItemChild,
        'filterModel'  => $authItemChildSearch,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'parent',
            'child',

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons'  => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-edit"></span>',
                            ['/rbac/auth_item_child/update', 'parent' => $model->parent, 'child' => $model->child]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            ['/rbac/auth_item_child/delete', 'parent' => $model->parent, 'child' => $model->child]);
                    },
                    'view'   => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            ['/rbac/auth_item_child/view', 'parent' => $model->parent, 'child' => $model->child]);
                    },

                ]
            ],
        ],
    ]); ?>


</div>

<?php

use app\models\AuthAssignmentSearch;
use app\models\model\BaseModel;
use yii\bootstrap\Modal;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $authAssignment ActiveDataProvider */
/* @var $authAssignmentSearch AuthAssignmentSearch */

$this->title = Yii::t('app', 'Auth Assignments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Auth Assignment'),
            ['create', 'slug' => 'auth-assignment'], [
                'class' => 'btn btn-success',
                'id'    => 'auth_assignment'
            ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $authAssignment,
        'filterModel'  => $authAssignmentSearch,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'item_name',
            [
                'attribute' => 'user_id',
                'value'     => function ($model) {
                    return $model->user->username ?? '';
                }
            ],
            [
                'attribute' => 'created_at',
                'value'     => function ($model) {
                    return BaseModel::dateFormat($model->created_at);
                }
            ],

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons'  => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-edit"></span>',
                            ['/rbac/auth_assignment/update', 'item_name' => $model->item_name, 'user_id' => $model->user_id]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            ['/rbac/auth_assignment/delete', 'item_name' => $model->item_name, 'user_id' => $model->user_id]);
                    },
                    'view'   => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            ['/rbac/auth_assignment/view', 'item_name' => $model->item_name, 'user_id' => $model->user_id]);
                    },

                ]
            ],
        ],
    ]); ?>

</div>

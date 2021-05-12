<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can('client')): ?>
            <?= Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'text',
            [
                'label'     => 'User',
                'attribute' => 'user_id',
                'value'     => function ($model) {
                    return $model->user->username ?? '';
                }
            ],
            'date',
            //'status',
            //'created_at',
            //'updated_at',

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons'  => [
                    'view'   => function ($url, $model) {
                        if (Yii::$app->user->can('client')) {
                            return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $url);
                        } else {
                            return '';
                        }
                    },
                    'update' => function ($url, $model) {
                        if (Yii::$app->user->can('client')) {
                            return Html::a('<i class="glyphicon glyphicon-pencil"></i>', $url);
                        } else {
                            return '';
                        }
                    },
                    'delete' => function ($url, $model) {
                        if (Yii::$app->user->can('client')) {
                            return Html::a('<i class="glyphicon glyphicon-trash"></i>', $url);
                        } else {
                            return '';
                        }
                    }
                ]
            ],
        ],
    ]); ?>


</div>

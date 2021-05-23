<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can('moderator')): ?>
            <?= Html::a(Yii::t('app', 'Create News'), ['create'], ['class' => 'btn btn-success']) ?>
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
            'text:ntext',
            [
                'label'     => 'User',
                'attribute' => 'author_id',
                'value'     => function ($model) {
                    return $model->user->username ?? '';
                }
            ],
            'date',
            //'status',
            //'updated_at',

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons'  => [
                    'view'   => function ($url, $model) {
                        if (Yii::$app->user->can('moderator') || Yii::$app->user->can('updateNews', ['view'])) {
                            return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $url);
                        } else {
                            return '';
                        }
                    },
                    'update' => function ($url, $model) {
                        if (Yii::$app->user->can('moderator') || Yii::$app->user->can('updateNews', ['update'])) {
                            return Html::a('<i class="glyphicon glyphicon-pencil"></i>', $url);
                        } else {
                            return '';
                        }
                    },
                    'delete' => function ($url, $model) {
                        if (Yii::$app->user->can('moderator')) {
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

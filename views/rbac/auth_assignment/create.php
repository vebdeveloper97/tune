<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AuthAssignment */

$this->title = Yii::t('app', 'Create Auth Assignment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Auth Assignments'), 'url' => ['rbac/auth-assignment/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

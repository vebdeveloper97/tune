<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItemChild */

$this->title = Yii::t('app', 'Create Auth Item Child');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Auth Item Children'), 'url' => ['rbac/auth-item-child/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-child-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
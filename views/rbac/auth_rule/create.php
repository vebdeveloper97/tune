<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AuthRule */

$this->title = Yii::t('app', 'Create Auth Rule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Auth Rules'), 'url' => ['rbac/auth-rule/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-rule-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

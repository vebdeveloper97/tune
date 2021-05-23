<?php

use app\models\AuthAssignment;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItemChild */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="auth-item-child-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'parent')->widget(Select2::class, [
                'data'          => AuthAssignment::getItemsList(),
                'options'       => [
                    'placeholder' => Yii::t('app', 'Select...')
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'child')->widget(Select2::class, [
                'data'          => [],
                'options'       => [
                    'placeholder' => Yii::t('app', 'Select...'),
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
$typeName1 = Yii::t('app', 'Role');
$typeName2 = Yii::t('app', 'Permission');
$js = <<< JS
    $(function(){
        $('#authitemchild-parent').change(function(){
            let val = $(this).val();
            $.ajax({
                url: '/rbac/auth-item-child',
                data: {'item_name': val},
                method: 'POST',
                success: function(response){
                    $('#authitemchild-child').empty().trigger('change');
                    if (response) {
                        for (let i = 0; i < response.length; i++) {
                            let name = response[i].name;
                            let type = response[i].type;
                            let typeName = "$typeName1";
                            if (type == 2) {
                                typeName = "$typeName2";
                            }
                            let option = new Option(name+' '+typeName,name);
                            $('#authitemchild-child').append(option);
                        }
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        })
    })        
JS;

$this->registerJs($js);

?>

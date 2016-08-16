<?php

/* @var $this \yii\web\View */
/* @var $form \yii\widgets\ActiveForm */
/* @var $model \common\models\RoleForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="role-form">
    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'name')->textInput()->label('角色唯一标识'); ?>

    <?php echo $form->field($model, 'description')->textInput()->label('角色描述'); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'btn btn-success']); ?>
    </div>

    <?php $form->end(); ?>
</div>

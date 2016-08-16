<?php

/* @var $this \yii\web\View */
/* @var $form \yii\widgets\ActiveForm */
/* @var $model \common\models\PermissionForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="permission-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'name')->textInput()->label('权限唯一标识'); ?>

    <?php echo $form->field($model, 'description')->textInput()->label('权限描述'); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'btn btn-success']); ?>
    </div>

    <?php $form->end(); ?>
</div>

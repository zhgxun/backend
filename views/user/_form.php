<?php

/* @var $this \yii\web\View */
/* @var $form \yii\widgets\ActiveForm */
/* @var $model \common\models\User */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'username')->textInput()->label('用户名'); ?>

    <?php echo $form->field($model, 'email')->textInput()->label('邮箱'); ?>

    <?php echo $form->field($model, 'password_hash')->passwordInput()->label('密码'); ?>

    <?php echo $form->field($model, 'level')->radioList(\common\base\User::getInstance()->getLevelKV())->label('账号等级'); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'btn btn-success']); ?>
    </div>

    <?php $form->end(); ?>
</div>

<?php

/* @var $this \yii\web\View */
/* @var $model \common\models\Menu */
/* @var $form \yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="form">
    <?php $form = ActiveForm::begin(); ?>

    <?php echo  $form->field($model, 'pid')->dropDownList(\common\base\Menu::getInstance()->getMenuOptionList())->label('选择父分类'); ?>

    <?php echo  $form->field($model, 'label')->textInput()->label('分类名称'); ?>

    <?php echo  $form->field($model, 'url')->textInput()->label('分类地址'); ?>

    <?php echo  $form->field($model, 'content')->textarea(['rows' => 2])->label('备注'); ?>

    <?php echo  $form->field($model, 'status')->radioList(\common\base\Menu::getInstance()->getStatusKV())->label('状态'); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'btn btn-success']); ?>
    </div>

    <?php $form->end(); ?>
</div>

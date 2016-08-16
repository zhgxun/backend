<?php

/* @var $this \yii\web\View */
/* @var $form \yii\widgets\ActiveForm */
/* @var $model \common\models\Link */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="link-form">
    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'title')->textInput()->label('标题'); ?>

    <?php echo $form->field($model, 'url')->textInput()->label('地址'); ?>

    <?php echo $form->field($model, 'content')->textarea(['rows' => 4])->label('备注'); ?>

    <?php echo $form->field($model, 'status')->radioList(\common\base\Link::getInstance()->getStatusKV()); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'btn btn-success']); ?>
    </div>

    <?php $form->end(); ?>
</div>

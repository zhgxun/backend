<?php

/* @var $this \yii\web\View */
/* @var $form \yii\widgets\ActiveForm */
/* @var $model \common\models\Sentence */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="sentence-form">
    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'title')->textarea(['rows' => 4])->label('标题'); ?>

    <?php echo $form->field($model, 'author')->textInput()->label('作者'); ?>

    <?php echo $form->field($model, 'quote')->textInput()->label('引自'); ?>

    <?php echo $form->field($model, 'content')->textarea(['rows' => 4])->label('备注'); ?>

    <?php echo $form->field($model, 'status')->radioList(\common\base\Sentence::getInstance()->getStatusKV())->label('状态'); ?>

    <div class="form-group col-lg-1 col-md-1 col-xs-2">
        <?php echo Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'btn btn-success']); ?>
    </div>

    <?php $form->end(); ?>
</div>

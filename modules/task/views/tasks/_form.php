<?php

/* @var $this yii\web\View */
/* @var $model common\models\task\Tasks */
/* @var $form yii\widgets\ActiveForm */
/* @var $hosts */
/* @var $branches */
/* @var $dataYearList */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="tasks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'task_type')->dropDownList(\common\base\task\Tasks::getInstance()->getTaskTypeKV())->label('任务类型'); ?>

    <?php echo $form->field($model, 'ipaddress')->dropDownList($hosts)->label('主机地址'); ?>

    <?php echo $form->field($model, 'code_branch')->dropDownList($branches)->label('代码分支'); ?>

    <?php echo $form->field($model, 'data_year')->dropDownList($dataYearList)->label('数据年份'); ?>

    <?php echo $form->field($model, 'command')->textInput(['maxlength' => true]); ?>

    <?php echo $form->field($model, 'parameters')->textarea(['rows' => 2]); ?>

    <?php echo $form->field($model, 'content')->textarea(['rows' => 2]); ?>


    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php $form->end(); ?>

</div>

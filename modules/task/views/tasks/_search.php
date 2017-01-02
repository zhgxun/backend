<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\search\task\TasksSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasks-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_name') ?>

    <?= $form->field($model, 'audit_name') ?>

    <?= $form->field($model, 'task_type') ?>

    <?= $form->field($model, 'ipaddress') ?>

    <?php // echo $form->field($model, 'code_branch') ?>

    <?php // echo $form->field($model, 'data_year') ?>

    <?php // echo $form->field($model, 'command') ?>

    <?php // echo $form->field($model, 'parameters') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'audit_date') ?>

    <?php // echo $form->field($model, 'task_status') ?>

    <?php // echo $form->field($model, 'audit_status') ?>

    <?php // echo $form->field($model, 'start_date') ?>

    <?php // echo $form->field($model, 'end_date') ?>

    <?php // echo $form->field($model, 'report') ?>

    <?php // echo $form->field($model, 'out_subscribe') ?>

    <?php // echo $form->field($model, 'error_subscribe') ?>

    <?php // echo $form->field($model, 'report_subscribe') ?>

    <?php // echo $form->field($model, 'out_file_path') ?>

    <?php // echo $form->field($model, 'error_file_path') ?>

    <?php // echo $form->field($model, 'report_file_path') ?>

    <?php // echo $form->field($model, 'ctime') ?>

    <?php // echo $form->field($model, 'utime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

/* @var $this \yii\web\View */
/* @var $form \yii\widgets\ActiveForm */
/* @var $model \common\models\Finance */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile('plugins/datetimepicker/css/bootstrap-datetimepicker.min.css');

?>
<div class="finance-form">
    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'type')->dropDownList(\common\base\Finance::getInstance()->getTypeKV())->label('选择类型'); ?>

    <?php echo $form->field($model, 'name')->textInput()->label('项目名称'); ?>

    <?php echo $form->field($model, 'date')->textInput()->label('记录日期'); ?>

    <?php echo $form->field($model, 'cost')->textInput()->label('花费'); ?>

    <?php echo $form->field($model, 'content')->textarea(['rows' => 4])->label('备注'); ?>

    <?php echo $form->field($model, 'status')->radioList(\common\base\Finance::getInstance()->getStatusKV()); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'btn btn-success']); ?>
    </div>

    <?php $form->end(); ?>
</div>
<?php
$this->registerJsFile('plugins/datetimepicker/js/bootstrap-datetimepicker.min.js', ['depends' => \backend\assets\AppAsset::className()]);
$this->registerJsFile('plugins/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', ['depends' => \backend\assets\AppAsset::className()]);
$this->registerJs('
    $("#finance-date").datetimepicker({
        "language" : "zh-CN",
        "format" : "yyyy-mm-dd hh:ii:ss"
    });
');
?>

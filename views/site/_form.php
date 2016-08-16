<?php

/* @var $this \yii\web\View */
/* @var $form \yii\widgets\ActiveForm */
/* @var $model \common\models\Article */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCss('
    .text {
        width : 100%;
        height : 500px;
    }
');

?>
<div class="site-form">
    <?php $form = ActiveForm::begin(['options' => [' name' => 'frm']]); ?>

    <?php echo $form->field($model, 'title')->textInput()->label('文章标题'); ?>

    <?php echo $form->field($model, 'type')->radioList(\common\base\Navigation::getInstance()->getNavigationKV())->label('文章类型'); ?>

    <?php echo $form->field($model, 'content')->textarea(['class' => 'text'])->label('文章内容'); ?>

    <?php echo $form->field($model, 'remark')->textarea(['rows' => 4])->label('备注'); ?>

    <?php echo $form->field($model, 'status')->radioList(\common\base\Article::getInstance()->getStatusKV())->label('状态'); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'btn btn-success']); ?>
    </div>

    <?php $form->end(); ?>
</div>
<?php
$this->registerCssFile('@web/plugins/kindeditor/themes/default/default.css', [
    'depends' => [backend\assets\AppAsset::className()],
]);
$this->registerJsFile('@web/plugins/kindeditor/kindeditor-all-min.js', [
    'depends' => [backend\assets\AppAsset::className()],
]);
$this->registerJs('
    KindEditor.ready(function(K) {
        window.editor = K.create(\'#article-content\', {
            "allowFileManager" : false,
            "uploadJson" : "' . \yii\helpers\Url::to(['upload'], true) . '",
            "afterCreate" : function(){this.sync();},
			"afterBlur" : function(){this.sync();}
        });
    });
');
?>

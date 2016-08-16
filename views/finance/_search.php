<?php

/* @var $this \yii\web\View */
/* @var $form \yii\widgets\ActiveForm */
/* @var $type */
/* @var $name */
/* @var $status */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$type = isset($_GET['type']) ? $_GET['type'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

?>
<div class="link-search row">
    <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']); ?>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('类型', 'type', ['class' => 'sr-only']);
            echo Html::dropDownList('type', $type, \common\base\Finance::getInstance()->getTypeKV(), ['class' => 'form-control', 'is' => 'type', 'prompt' => '类型(全部)']);
        ?>
    </div>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('项目名称', 'name', ['class' => 'sr-only']);
            echo Html::textInput('name', $name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => '项目名称']);
        ?>
    </div>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('状态', 'status', ['class' => 'sr-only']);
            echo Html::dropDownList('status', $status, \common\base\Finance::getInstance()->getStatusKV(), ['class' => 'form-control', 'id' => 'status', 'prompt' => '状态(全部)']);
        ?>
    </div>

    <div class="form-group col-lg-1 col-md-1 col-xs-2">
        <?php echo Html::submitButton('搜索', ['class' => 'btn btn-success']); ?>
    </div>

    <?php $form->end(); ?>
</div>

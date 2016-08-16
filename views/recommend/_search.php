<?php

/* @var $this \yii\web\View */
/* @var $form \yii\widgets\ActiveForm */
/* @var $title */
/* @var $url */
/* @var $source */
/* @var $type */
/* @var $status */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$title = isset($_GET['title']) ? $_GET['title'] : '';
$url = isset($_GET['url']) ? $_GET['url'] : '';
$source = isset($_GET['source']) ? $_GET['source'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

?>
<div class="recommend-search row">
    <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']); ?>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('标题', 'title', ['class' => 'sr-only']);
            echo Html::textInput('title', $title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => '标题']);
        ?>
    </div>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('地址', 'url', ['class' => 'sr-only']);
            echo Html::textInput('url', $url, ['class' => 'form-control', 'id' => 'url', 'placeholder' => '地址']);
        ?>
    </div>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('来源', 'source', ['class' => 'sr-only']);
            echo Html::textInput('source', $source, ['class' => 'form-control', 'placeholder' => '来源']);
        ?>
    </div>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('类型', 'type', ['class' => 'sr-only']);
            echo Html::dropDownList('type', $type, \common\base\Recommend::getInstance()->getTypeKV(), ['class' => 'form-control', 'prompt' => '类型']);
        ?>
    </div>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('状态', 'status', ['class' => 'sr-only']);
            echo Html::dropDownList('status', $status, \common\base\Recommend::getInstance()->getStatusKV(), ['class' => 'form-control', 'prompt' =>'状态']);
        ?>
    </div>

    <div class="form-group col-lg-1 col-md-1 col-xs-2">
        <?php echo Html::submitButton('搜索', ['class' => 'btn btn-success']); ?>
    </div>

    <?php $form->end(); ?>
</div>

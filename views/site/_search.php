<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $form \yii\widgets\ActiveForm */
/* @var $title */
/* @var $type */
/* @var $content */
/* @var $status */

$title = isset($_GET['title']) ? $_GET['title'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';
$content = isset($_GET['content']) ? $_GET['content'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

?>
<div class="article-search row">
    <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']); ?>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('标题', 'title', ['class' => 'sr-only']);
            echo Html::textInput('title', $title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => '标题']);
        ?>
    </div>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('类型', 'type', ['class' => 'sr-only']);
            echo Html::dropDownList('type', $type, \common\base\Menu::getInstance()->getStatusKV(), ['class' => 'form-control', 'id' => 'type', 'prompt' => '类型']);
        ?>
    </div>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('内容', 'content', ['class' => 'sr-only']);
            echo Html::textInput('content', $content, ['class' => 'form-control', 'id' => 'content', 'placeholder' => '内容']);
        ?>
    </div>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('状态', 'status', ['class' => 'sr-only']);
            echo Html::dropDownList('status', $status, \common\base\Article::getInstance()->getStatusKV(), ['class' => 'form-control', 'id' => 'status', 'prompt' => '状态']);
        ?>
    </div>

    <div class="form-group col-lg-1 col-md-1 col-xs-2">
        <?php echo Html::submitButton('搜索', ['class' => 'btn btn-success']); ?>
    </div>

    <?php $form->end(); ?>
</div>

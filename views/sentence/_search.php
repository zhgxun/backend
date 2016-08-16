<?php

/* @var $this \yii\web\View */
/* @var $form \yii\widgets\ActiveForm */
/* @var $title */
/* @var $author */
/* @var $quote */
/* @var $status */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$title = isset($_GET['title']) ? $_GET['title'] : '';
$author = isset($_GET['author']) ? $_GET['author'] : '';
$quote = isset($_GET['quote']) ? $_GET['quote'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

?>
<div class="sentence-form row">
    <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']); ?>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('标题', 'title', ['class' => 'sr-only']);
            echo Html::textInput('title', $title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => '标题']);
        ?>
    </div>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('作者', 'author', ['class' => 'sr-only']);
            echo Html::textInput('author', $author, ['class' => 'form-control', 'id' => 'author', 'placeholder' => '作者']);
        ?>
    </div>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('引自', 'quote', ['class' => 'sr-only']);
            echo Html::textInput('quote', $quote, ['class' => 'form-control', 'id' => 'quote', 'placeholder' => '引自']);
        ?>
    </div>

    <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <?php
            echo Html::label('状态', 'status', ['class' => 'sr-only']);
            echo Html::dropDownList('status', $status, \common\base\Sentence::getInstance()->getStatusKV(), ['id' => 'status', 'prompt' => '状态', 'class' => 'form-control']);
        ?>
    </div>

    <div class="form-group col-lg-1 col-md-1 col-xs-3">
        <?php echo Html::submitButton('搜索', ['class' => 'btn btn-success']); ?>
    </div>

    <?php $form->end(); ?>
</div>

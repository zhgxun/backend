<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sentence */

$this->title = '修改: ' . ' ' . mb_substr($model->title, 0, 15, 'utf-8');
$this->params['breadcrumbs'][] = ['label' => '每日一语', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="menu-update">

    <h4><?php echo Html::encode($this->title); ?></h4>

    <?php
        $model->loadDefaultValues();
        echo $this->render('_form', ['model'  => $model]);
    ?>

</div>

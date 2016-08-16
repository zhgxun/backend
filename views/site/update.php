<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = '修改: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="menu-update">

    <h4><?php echo Html::encode($this->title); ?></h4>

    <?php
        $model->loadDefaultValues();
        echo $this->render('_form', ['model'  => $model]);
    ?>

</div>

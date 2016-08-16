<?php

/* @var $this \yii\web\View */
/* @var $model \common\models\Menu */

$this->title = '添加菜单';
$this->params['breadcrumbs'][] = ['label' => '菜单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html;

?>
<div class="create">
    <h4><?php echo Html::encode($this->title); ?></h4>

    <?php
        $model->loadDefaultValues();
        echo $this->render('_form', ['model' => $model]);
    ?>
</div>

<?php

/* @var $model \common\models\Menu */
/* @var $this \yii\web\View */

$this->title = $model->label;
$this->params['breadcrumbs'][] = ['label' => '菜单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html;

?>
<div class="update">
    <h4><?php echo Html::encode($this->title); ?></h4>

    <?php
        $model->loadDefaultValues();
        echo $this->render('_form', ['model' => $model]);
    ?>
</div>

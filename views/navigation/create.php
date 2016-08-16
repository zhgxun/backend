<?php

/* @var $this \yii\web\View */
/* @var $model \common\models\Navigation */

use yii\helpers\Html;

$this->title = '添加导航';
$this->params['breadcrumbs'][] = ['label' => '导航管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="create">
    <h4><?php echo Html::encode($this->title); ?></h4>

    <?php
        $model->loadDefaultValues();
        echo $this->render('_form', ['model' => $model]);
    ?>
</div>

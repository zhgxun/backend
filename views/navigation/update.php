<?php

/* @var $this \yii\web\View */
/* @var $model \common\models\Navigation */

use yii\helpers\Html;

$this->title = $model->label;
$this->params['breadcrumbs'][] = ['label' => '导航管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="update">
    <h4><?php echo Html::encode($this->title); ?></h4>

    <?php
        $model->loadDefaultValues();
        echo $this->render('_form', ['model' => $model]);
    ?>
</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Finance */

$this->title = '修改: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '理财管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="finance-update">

    <h4><?php echo Html::encode($this->title); ?></h4>

    <?php
        $model->loadDefaultValues();
        echo $this->render('_form', ['model'  => $model]);
    ?>

</div>

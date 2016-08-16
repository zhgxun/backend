<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Link */

$this->title = '修改: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '友情链接', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="link-update">

    <h4><?php echo Html::encode($this->title); ?></h4>

    <?php
        $model->loadDefaultValues();
        echo $this->render('_form', ['model'  => $model]);
    ?>

</div>

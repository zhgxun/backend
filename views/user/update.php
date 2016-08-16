<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = '修改: ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="user-update">

    <h4><?php echo Html::encode($this->title); ?></h4>

    <?php
        $model->loadDefaultValues();
        echo $this->render('_form', ['model'  => $model]);
    ?>

</div>

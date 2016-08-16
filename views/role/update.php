<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RoleForm */

$this->title = '修改: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '角色列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="role-update">

    <h4><?php echo Html::encode($this->title); ?></h4>

    <?php echo $this->render('_form', ['model'  => $model]); ?>

</div>

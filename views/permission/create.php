<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PermissionForm */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '权限列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="permission-create">

    <h4><?php echo Html::encode($this->title) ?></h4>

    <?php
        if (Yii::$app->getSession()->getFlash('success')) {
            echo \yii\bootstrap\Alert::widget([
                'options' => ['class' => 'alert alert-success'],
                'body' => Yii::$app->getSession()->getFlash('success'),
            ]);
        }
    ?>

    <?php echo  $this->render('_form', ['model' => $model]); ?>

</div>

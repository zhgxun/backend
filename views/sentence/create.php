<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sentence */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '每日一语', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="recommend-create">

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

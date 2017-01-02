<?php

/* @var $this yii\web\View */
/* @var $model common\models\task\Tasks */
/* @var $hosts */
/* @var $branches */
/* @var $dataYearList */

use yii\helpers\Html;

$this->title = '更新: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '任务管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="tasks-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'hosts' => $hosts,
        'branches' => $branches,
        'dataYearList' => $dataYearList,
    ]) ?>

</div>

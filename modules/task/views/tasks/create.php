<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\task\Tasks */
/* @var $hosts */
/* @var $branches */
/* @var $dataYearList */

$this->title = '创建';
$this->params['breadcrumbs'][] = ['label' => '任务管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
        'hosts' => $hosts,
        'branches' => $branches,
        'dataYearList' => $dataYearList,
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\task\Tasks */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_name',
            'audit_name',
            'task_type',
            'ipaddress',
            'code_branch',
            'data_year',
            'command',
            'parameters:ntext',
            'content',
            'audit_date',
            'task_status',
            'audit_status',
            'start_date',
            'end_date',
            'report:ntext',
            'out_subscribe:ntext',
            'error_subscribe:ntext',
            'report_subscribe:ntext',
            'out_file_path',
            'error_file_path',
            'report_file_path',
            'ctime',
            'utime',
        ],
    ]) ?>

</div>

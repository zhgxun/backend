<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss('
    th {
        width : 10%;
    }
');

?>

<div class="menu-view">
    <h3><?php echo Html::encode($this->title); ?></h3>

    <p>
        <?php echo Html::a('添加', ['create'], ['class' => 'btn btn-success']); ?>
        <?php echo Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <table class="table table-hover table-bordered">
        <tr>
            <th>ID</th>
            <td><?php echo $model->id; ?></td>
        </tr>
        <tr>
            <th>标题</th>
            <td><?php echo $model->title; ?></td>
        </tr>
        <tr>
            <th>类型</th>
            <td><?php echo \common\base\Navigation::getInstance()->getNameById($model->type); ?></td>
        </tr>
        <tr>
            <th>内容</th>
            <td><?php echo $model->content; ?></td>
        </tr>
        <tr>
            <th>状态</th>
            <td><?php echo \common\base\Article::getInstance()->statusToDes($model->status); ?></td>
        </tr>
        <tr>
            <th>创建时间</th>
            <td><?php echo date('Y-m-d H:i:s', $model->ctime); ?></td>
        </tr>
        <tr>
            <th>更新时间</th>
            <td><?php echo date('Y-m-d H:i:s', $model->utime); ?></td>
        </tr>
    </table>
</div>
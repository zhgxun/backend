<?php

/* @var $this yii\web\View */
/* @var $total */
/* @var $list */

use yii\helpers\Html;

$this->title = '任务管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p class="text-info">共搜索到<?php echo $total; ?>条符合条件的记录</p>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>主机</th>
                <th>命令</th>
                <th>参数</th>
                <th>备注</th>
                <th>创建</th>
                <th>审核</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $value): ?>
                <tr>
                    <td><?php echo $value['ipaddress']; ?></td>
                    <td><?php echo $value['command']; ?></td>
                    <td><?php echo $value['parameters']; ?></td>
                    <td><?php echo $value['content']; ?></td>
                    <td><?php echo $value['user_name']; ?></td>
                    <td><?php echo $value['audit_name']; ?></td>
                    <td><?php echo $value['task_status']; ?></td>
                    <td>
                        <?php
                            echo Html::a('查看', ['view', 'id' => $value['id']], ['target' => '_blank']);
                            echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
                            echo Html::a('编辑', ['update', 'id' => $value['id']], ['target' => '_blank']);
                            echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
                            echo Html::a('删除', ['delete', 'id' => $value['id']], ['class' => 'delete']);
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
$this->registerJs('
    $(".delete").click(function() {
        if (confirm("确认删除?")) {
            $.ajax({
                "type"  : "POST",
                "url"   : $(this).attr("href"),
                success : function(d) {
                    if (d == "yes") {
                        window.location.reload();
                    } else {
                        alert("删除失败,请刷新重试一次");
                        return false;
                    }
                }
            });
        }
        return false;
    });
');
?>

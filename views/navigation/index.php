<?php

/* @var $this \yii\web\View */
/* @var $model \common\models\Navigation */
/* @var $total */
/* @var $list */
/* @var $pages */

use yii\helpers\Html;

$this->title = '导航管理';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="index">
    <h4><?php echo Html::encode($this->title); ?></h4>

    <p>
        <?php echo Html::a('添加导航', ['create'], ['class' => 'btn btn-success']); ?>
    </p>

    <?php \yii\widgets\Pjax::begin(); ?>
    <p class="text-info">共搜索到<?php echo $total; ?>条符合条件的记录</p>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>名称</th>
                <th>路径</th>
                <th>备注</th>
                <th>更新时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $value): ?>
                <tr>
                    <td><?php echo $value['id']; ?></td>
                    <td><?php echo $value['label']; ?></td>
                    <td><?php echo $value['url']; ?></td>
                    <td><?php echo $value['content']; ?></td>
                    <td><?php echo date('Y-m-d', $value['utime']); ?></td>
                    <td>
                        <?php
                            echo Html::a('编辑', ['update', 'id' => $value['id']]);
                            if ($value['status'] != 9) {
                                echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
                                echo Html::a('删除', ['delete', 'id' => $value['id']], ['class' => 'delete']);
                            }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo $pages; ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
<?php
$this->registerJs('
    $(".delete").on("click", function() {
        if (confirm("确认删除?")) {
            $.ajax({
                "type"  : "GET",
                "url"   : $(this).prop("href"),
                success : function(data) {
                    if (data == "yes") {
                        window.location.reload();
                    } else {
                        alert("删除失败");
                        return false;
                    }
                }
            });
        }
        return false;
    });
');
?>

<?php

/* @var $this \yii\web\View */
/* @var $total */
/* @var $list */
/* @var $pages */

$this->title = '菜单管理';
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html;

?>
<div class="index">
    <h4><?php echo Html::encode($this->title); ?></h4>

    <p>
        <?php echo Html::a('添加菜单', ['create'], ['class' => 'btn btn-success']); ?>
    </p>

    <?php \yii\widgets\Pjax::begin(); ?>
    <p>共搜索到<?php echo $total; ?>条符合条件的记录</p>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>父级菜单</th>
                <th>标签</th>
                <th>地址</th>
                <th>备注</th>
                <th>状态</th>
                <th>更新时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $value): ?>
                <tr>
                    <td><?php echo \common\base\Menu::getInstance()->getLabelByParentId($value['pid']) . '(' . $value['pid'] . ')'; ?></td>
                    <td><?php echo $value['label'] . '(' . $value['id'] . ')'; ?></td>
                    <td><?php echo $value['url']; ?></td>
                    <td><?php echo $value['content']; ?></td>
                    <td><?php echo \common\base\Menu::getInstance()->statusToDes($value['status']); ?></td>
                    <td><?php echo date('Y-m-d', $value['utime']); ?></td>
                    <td>
                        <?php
                            if ($value['status'] != 9) {
                                echo Html::a('编辑', ['update', 'id' => $value['id']]);
                                echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
                                echo Html::a('删除', ['delete', 'id' => $value['id']], ['class' => 'delete']);
                            } else {
                                echo '已删除';
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
                    "type"  : "POST",
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

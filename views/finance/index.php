<?php

/* @var $this \yii\web\View */
/* @var $total */
/* @var $list */
/* @var $pages */

use yii\helpers\Html;

$this->title = '理财记录';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="finance-index">
    <h4><?php echo Html::encode($this->title); ?></h4>

    <?php echo $this->render('_search'); ?>

    <p><?php echo Html::a('添加', ['create'], ['class' => 'btn btn-success']); ?></p>

    <?php \yii\widgets\Pjax::begin(); ?>
    <p class="text-info">共搜索到<?php echo $total; ?>条符合条件的记录</p>
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>类型</th>
                <th>项目名称</th>
                <th>日期</th>
                <th>花费</th>
                <th>备注</th>
                <th>更新时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $value): ?>
                <tr>
                    <td><?php echo $value['id']; ?></td>
                    <td><?php echo \common\base\Finance::getInstance()->typeToDes($value['type']); ?></td>
                    <td><?php echo $value['name']; ?></td>
                    <td><?php echo $value['date']; ?></td>
                    <td><?php echo $value['cost']; ?></td>
                    <td><?php echo $value['content']; ?></td>
                    <td><?php echo $value['utime']; ?></td>
                    <td>
                        <?php
                            echo Html::a('编辑', ['update', 'id' => $value['id']]);
                            echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
                            echo Html::a('删除', ['delete', 'id' => $value['id']], ['class' => 'delete']);
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php \yii\widgets\Pjax::end(); ?>
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

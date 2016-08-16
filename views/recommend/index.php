<?php

/* @var $this \yii\web\View */
/* @var $total */
/* @var $list */
/* @var $pages */

use yii\helpers\Html;

$this->title = '推荐阅读';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="recommend-index">
    <h4><?php echo Html::encode($this->title); ?></h4>

    <?php echo $this->render('_search'); ?>

    <p><?php echo Html::a('添加', ['create'], ['class' => 'btn btn-success']); ?></p>

    <?php \yii\widgets\Pjax::begin(); ?>
    <p class="text-info">共搜素到<?php echo $total; ?>条符合条件的记录</p>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="20%">标题</th>
                <th width="10%">来源</th>
                <th width="25%">地址</th>
                <th width="5%">类型</th>
                <th width="5%">状态</th>
                <th width="10%">创建时间</th>
                <th width="15%">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $value): ?>
                <tr>
                    <td><?php echo $value['id']; ?></td>
                    <td><?php echo $value['title']; ?></td>
                    <td><?php echo $value['source']; ?></td>
                    <td style="word-break: break-all;"><a href="<?php echo $value['url']; ?>" target="_blank"><?php echo $value['url']; ?></a></td>
                    <td><?php echo \common\base\Recommend::getInstance()->typeToDes($value['type']); ?></td>
                    <td><?php echo \common\base\Recommend::getInstance()->statusToDes($value['status']); ?></td>
                    <td><?php echo date('Y-m-d H:i:s', $value['ctime']); ?></td>
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
    <?php echo $pages; ?>
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

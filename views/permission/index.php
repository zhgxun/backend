<?php

/* @var $this \yii\web\View */
/* @var $permissions */

use yii\helpers\Html;

$this->title = '权限列表';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="permission-index">
    <h4><?php echo Html::encode($this->title); ?></h4>

    <p>
        <?php echo Html::a('添加', ['create'], ['class' => 'btn btn-success']); ?>
        <?php echo Html::a('批量删除', ['delete'], ['class' => 'btn btn-warning', 'id' => 'batch']); ?>
    </p>

    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>
                    <label for="all">
                        <input type="checkbox" id="all" value="全选" />
                    </label>
                </th>
                <th>权限唯一标识</th>
                <th>权限描述</th>
                <th>创建时间</th>
                <th>更新时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($permissions as $value): ?>
                <tr>
                    <td>
                        <label>
                            <input type="checkbox" name="id[]" value="<?php echo $value['name']; ?>" />
                        </label>
                    </td>
                    <td><?php echo $value['name']; ?></td>
                    <td><?php echo $value['description']; ?></td>
                    <td><?php echo date('Y-m-d H:i:s', $value['createdAt']); ?></td>
                    <td><?php echo date('Y-m-d H:i:s', $value['updatedAt']); ?></td>
                    <td>
                        <?php
                            echo Html::a('编辑', ['update', 'id' => $value['name']]);
                            echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
                            echo Html::a('删除', ['delete', 'id' => $value['name']], ['class' => 'delete']);
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
$this->registerJs('
    $("#all").on("click", function() {
        if ($(this).is(":checked")) {
            $("input[name=\"id[]\"]").prop("checked", true);
        } else {
            $("input[name=\"id[]\"]").prop("checked", false);
        }
    });

    $("#batch").on("click", function() {
        var id = [];
        $("input[name=\"id[]\"]").each(function() {
            if ($(this).is(":checked")) {
                id.push($(this).val());
            }
        });
        if (id.length == 0) {
            alert("没有可删除的权限标识");
            return false;
        }
        if (confirm("确认批量删除?")) {
            $.ajax({
                "type"    : "POST",
                "url"     : $(this).attr("href"),
                "data"    : {id : id},
                "success" : function(d) {
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

    $(".delete").on("click", function() {
        if (confirm("确认删除?")) {
            $.ajax({
                "type"    : "POST",
                "url"     : $(this).attr("href"),
                "success" : function(d) {
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

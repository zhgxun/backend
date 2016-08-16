<?php

/* @var $this \yii\web\View */
/* @var $role */
/* @var $userIds */
/* @var $total */
/* @var $list */
/* @var $total */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '管理员列表';

$this->params['breadcrumbs'][] = ['label' => '角色管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="role-user">
    <h4><?php echo Html::encode($this->title); ?></h4>

    <?php \yii\widgets\Pjax::begin(); ?>
    <p class="text-info">共查找到<?php echo $total; ?>条符合条件的记录</p>
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>授予</th>
                <th>用户ID</th>
                <th>用户名</th>
                <th>用户邮箱</th>
                <th>创建时间</th>
                <th>更新时间</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list as $value): ?>
                <tr>
                    <td>
                        <label>
                            <?php if (in_array($value['id'], $userIds)): ?>
                                <input type="checkbox" checked name="id[]" value="<?php echo $value['id']; ?>" />
                            <?php else:?>
                                <input type="checkbox" name="id[]" value="<?php echo $value['id']; ?>" />
                            <?php endif; ?>
                        </label>
                    </td>
                    <td><?php echo $value['id']; ?></td>
                    <td><?php echo $value['username']; ?></td>
                    <td><?php echo $value['email']; ?></td>
                    <td><?php echo date('Y/m/d H:i:s', $value['created_at']); ?></td>
                    <td><?php echo date('Y/m/d H:i:s', $value['updated_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
<?php
$this->registerJs('
    $("input[name=\"id[]\"]").on("click", function() {
        if ($(this).is(":checked")) {
            var type = "add";
        } else {
            var type = "delete";
        }
        $.ajax({
            "url" : "' . Url::to(['setrole']) . '",
            "type" : "POST",
            "data" : {id : "' . $role . '", userid : $(this).val(), type : type},
            "success" : function(d) {
                var d = $.parseJSON(d);
                if (d.error == 0) {
                    $().toastmessage("showSuccessToast", d.message);
                } else {
                    $().toastmessage("showErrorToast", d.message);
                }
                return false;
            }
        });
    });
');
?>

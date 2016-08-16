<?php

/* @var $this \yii\web\View */
/* @var $role */
/* @var $permissions */
/* @var $currentPermissions */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '权限列表';

$this->params['breadcrumbs'][] = ['label' => '角色管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="role-permission">
    <h4><?php echo Html::encode($this->title); ?></h4>

    <?php \yii\widgets\Pjax::begin(); ?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>授予</th>
                <th>权限资源唯一标识符</th>
                <th>描述</th>
                <th>创建时间</th>
                <th>更新时间</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($permissions as $permission): ?>
                <tr>
                    <td>
                        <label>
                            <?php if (in_array($permission['name'], $currentPermissions)): ?>
                                <input type="checkbox" checked name="id[]" value="<?php echo $permission['name']; ?>" />
                            <?php else: ?>
                                <input type="checkbox" name="id[]" value="<?php echo $permission['name']; ?>" />
                            <?php endif; ?>
                        </label>
                    </td>
                    <td><?php echo $permission['name']; ?></td>
                    <td><?php echo $permission['description']; ?></td>
                    <td><?php echo $permission['createdAt']; ?></td>
                    <td><?php echo $permission['updatedAt']; ?></td>
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
            "url" : "' . Url::to(['setpermission']) . '",
            "type" : "POST",
            "data" : {id : "' . $role . '", permission : $(this).val(), type : type},
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

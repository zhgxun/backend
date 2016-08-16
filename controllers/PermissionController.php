<?php

namespace backend\controllers;

/**
 * 权限管理
 * type = 2
 * @package backend\controllers
 */
class PermissionController extends Base
{
    /**
     * 权限列表
     * 表auth_item中type = 2
     * @return string
     */
    public function actionIndex()
    {
        $auth = \Yii::$app->getAuthManager();
        $permissions = $auth->getPermissions();
        $permissions = \yii\helpers\ArrayHelper::toArray($permissions);

        return $this->render('index', ['permissions' => $permissions]);
    }

    /**
     * 创建权限
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new \common\models\PermissionForm();
        $model->isNewRecord = true;
        if (\Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(\Yii::$app->getRequest()->post())) {
                return $this->render('create', ['model' => $model]);
            }
            if (!trim($model->name)) {
                $model->addError('name', '权限内容不能为空');
            }
            $auth = \Yii::$app->getAuthManager();
            if ($auth->getPermission($model->name)) {
                $model->addError('name', '权限内容已经存在');
            } else {
                $item = $auth->createPermission($model->name);
                $item->description = $model->description;
                // 添加权限
                if ($auth->add($item)) {
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * 编辑权限标识
     * @param string $id 权限唯一标识
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = new \common\models\PermissionForm();
        $model->isNewRecord = false;
        $auth = \Yii::$app->getAuthManager();
        $item = $auth->getPermission($id);
        if (\Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(\Yii::$app->getRequest()->post())) {
                return $this->render('update', ['model' => $model]);
            }
            if (!trim($model->name)) {
                $model->addError('name', '权限名称不能为空');
            }
            $item->name = trim($model->name);
            $item->description = trim($model->description);
            if ($auth->update($id, $item)) {
                return $this->redirect(['index']);
            }
        }
        $model->name = $id;
        $model->description = $item->description;

        return $this->render('update', ['model' => $model]);
    }

    /**
     * 删除权限 单个/批量
     * @param string $id 权限标识
     * @return string
     */
    public function actionDelete($id = '')
    {
        if (!\Yii::$app->getRequest()->getIsPost()) {
            return 'no';
        }
        if ($id) {
            $permissions = [$id];
        } else {
            $permissions = isset($_POST['id']) && is_array($_POST['id']) ? $_POST['id'] : [];
        }
        if (empty($permissions)) {
            return 'no';
        }
        $auth = \Yii::$app->getAuthManager();
        try {
            foreach ($permissions as $permission) {
                if (!trim($permission)) {
                    continue;
                }
                $_permission = $auth->getPermission(trim($permission));
                if (!$auth->remove($_permission)) {
                    return 'no';
                }
            }
        } catch (\Exception $e) {
            return 'no';
        }
        return 'yes';
    }
}

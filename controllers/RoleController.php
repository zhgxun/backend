<?php

namespace backend\controllers;

/**
 * 角色管理
 * type = 1
 * @package backend\controllers
 */
class RoleController extends Base
{
    /**
     * 角色列表
     * 表auth_item中type = 1
     * @return string
     */
    public function actionIndex()
    {
        $auth = \Yii::$app->getAuthManager();
        $roles = $auth->getRoles();
        $roles = \yii\helpers\ArrayHelper::toArray($roles);

        return $this->render('index', ['roles' => $roles]);
    }

    /**
     * 创建角色
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new \common\models\RoleForm();
        $model->isNewRecord = true;
        if (\Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(\Yii::$app->getRequest()->post())) {
                return $this->render('create', ['model' => $model]);
            }
            if (!trim($model->name)) {
                $model->addError('name', '角色名称不能为空');
            }
            $auth = \Yii::$app->getAuthManager();
            if ($auth->getRole(trim($model->name))) {
                $model->addError('name', '角色已经存在');
            } else {
                $item = $auth->createRole(trim($model->name));
                $item->description = trim($model->description);
                // 添加角色
                if ($auth->add($item)) {
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * 角色编辑
     * @param string $id 角色标识
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = new \common\models\RoleForm();
        $model->isNewRecord = false;
        $auth = \Yii::$app->getAuthManager();
        $item = $auth->getRole($id);
        if (\Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(\Yii::$app->getRequest()->post())) {
                return $this->render('update', ['model' => $model]);
            }
            if (!trim($model->name)) {
                $model->addError('name', '角色标识不能为空');
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
     * 角色删除 单个/批量
     * @param string $id
     * @return string
     */
    public function actionDelete($id = '')
    {
        if (!\Yii::$app->getRequest()->getIsPost()) {
            return 'no';
        }
        if ($id) {
            $roles = [$id];
        } else {
            $roles = isset($_POST['id']) && is_array($_POST['id']) ? $_POST['id'] : [];
        }
        if (empty($roles)) {
            return 'no';
        }
        $auth = \Yii::$app->getAuthManager();
        try {
            foreach ($roles as $role) {
                if (!trim($role)) {
                    continue;
                }
                $_role = $auth->getRole(trim($role));
                if (!$auth->remove($_role)) {
                    return 'no';
                }
            }
        } catch (\Exception $e) {
            return 'no';
        }
        return 'yes';
    }

    /**
     * 管理员列表
     * @param string $id 角色名称
     * @return string
     */
    public function actionUser($id)
    {
        $query = \common\models\User::find();
        $query->where(' `status` != 9');
        $query->orderBy(' `id` DESC');
        $total = $query->count();
        $pageSize = 20;
        $pager = new \common\base\Page();
        $pager->pageName = 'page';
        $pages = $pager->show($total, $pageSize);
        $page = isset($request['page']) ? $request['page'] : 1;
        $offset = $pageSize * ($page - 1);
        if ($offset >= $total) {
            $offset = $total;
        };
        $query->offset($offset);
        $query->limit($pageSize);
        $query->orderBy(' `id` DESC');
        $list = $query->asArray()->all();

        // 获得该角色已有用户列表,该表名为auth_assignment,存有字段user_id, item_name
        $userList = (new \yii\db\Query())
            ->select(' `user_id`')
            ->from((new \yii\rbac\DbManager())->assignmentTable)
            ->where(' `item_name` = :itemName', [
            ':itemName' => trim($id),
        ])->all();
        $userIds = array_unique(\yii\helpers\ArrayHelper::getColumn($userList, 'user_id'));

        return $this->render('user', [
            'pages' => $pages, 'total' => $total, 'list' => $list, 'role' => trim($id), 'userIds' => $userIds,
        ]);
    }

    /**
     * 分配/删除角色到用户
     * @return string
     */
    public function actionSetrole()
    {
        $msg = ['error' => 1, 'message' => '参数错误'];
        $request = \Yii::$app->getRequest()->post();
        if (!isset($request['id'], $request['userid'], $request['type']) || !in_array($request['type'], ['add', 'delete'])) {
            return json_encode($msg);
        }
        $auth = \Yii::$app->getAuthManager();
        $role = $auth->getRole(trim($request['id']));
        $result = false;
        $message = '操作失败';
        try {
            switch ($request['type']) {
                case 'add':
                    $message = '角色分配成功';
                    $result = $auth->assign($role, $request['userid']);
                    break;
                case 'delete':
                    $message = '角色删除成功';
                    $result = $auth->revoke($role, $request['userid']);
                    break;
            }
            if ($result) {
                $msg = ['error' => 0, 'message' => $message];
            } else {
                $msg['message'] = $message;
            }
            return json_encode($msg);
        } catch (\Exception $e) {
            $msg['message'] = \yii\helpers\Json::encode($e->getMessage());
            return json_encode($msg);
        }
    }

    /**
     * 权限资源列表
     * @param string $id 角色名称
     * @return string
     */
    public function actionPermission($id)
    {
        $auth = \Yii::$app->getAuthManager();
        $permissions = $auth->getPermissions();
        $currentPermissions = $auth->getPermissionsByRole(trim($id));

        $permissions = \yii\helpers\ArrayHelper::toArray($permissions);
        $currentPermissions = \yii\helpers\ArrayHelper::getColumn($currentPermissions, 'name');

        return $this->render('permission', [
            'permissions' => $permissions, 'currentPermissions' => $currentPermissions, 'role' => trim($id),
        ]);
    }

    /**
     * 添加/删除权限资源
     * @return string
     */
    public function actionSetpermission()
    {
        $msg = ['error' => 1, 'message' => '参数错误'];
        $request = \Yii::$app->getRequest()->post();
        if (!isset($request['id'], $request['permission'], $request['type']) || !in_array($request['type'], ['add', 'delete'])) {
            return json_encode($msg);
        }
        $auth = \Yii::$app->getAuthManager();
        $role = $auth->getRole(trim($request['id']));
        $permission = $auth->getPermission($request['permission']);
        $result = false;
        $message = '操作失败';
        switch ($request['type']) {
            case 'add':
                $message = '权限资源添加成功';
                $result = $auth->addChild($role, $permission);
                break;
            case 'permission':
                $message = '权限资源删除成功';
                $result = $auth->removeChild($role, $permission);
                break;
        }
        if ($result) {
            $msg = ['error' => 0, 'message' => $message];
        } else {
            $msg = ['message' => $message];
        }
        return json_encode($msg);
    }
}

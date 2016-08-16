<?php

namespace backend\controllers;

class UserController extends Base
{
    public function actionIndex()
    {
        $query = \common\models\User::find();
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

        return $this->render('index', ['pages' => $pages, 'total' => $total, 'list' => $list]);
    }

    /**
     * 创建管理员
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new \common\models\User();
        $model->level = 1;
        if (\Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(\Yii::$app->getRequest()->post())) {
                return $this->render('create', ['model' => $model]);
            }
            if (!trim($model->username)) {
                $model->addError('username', '用户名不可为空');
            }
            if (!trim($model->email)) {
                $model->addError('email', '邮箱不可为空');
            }
            if (!trim($model->password_hash)) {
                $model->addError('password_hash', '密码不可为空');
            }
            if (!\common\base\Helper::getInstance()->isEmail($model->email)) {
                $model->addError('email', '邮箱格式不正确');
            }
            if (\common\base\User::getInstance()->getByUserName($model->username)) {
                $model->addError('username', '用户名已经存在');
            }
            if (\common\base\User::getInstance()->getByEmail($model->email)) {
                $model->addError('email', '邮箱已经存在');
            }
            if ($model->getErrors()) {
                return $this->render('update', ['model' => $model]);
            }
            $model->setPassword($model->password_hash); // 系统生成密码hash
            $model->generateAuthKey(); // 系统生成认证key
            $model->created_at = $model->updated_at = time();
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * 更新管理员信息
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->getById($id);
        $model->password_hash = '';
        if (\Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(\Yii::$app->getRequest()->post())) {
                return $this->render('update', ['model' => $model]);
            }
            if (!trim($model->username)) {
                $model->addError('username', '用户名不可为空');
            }
            if (!trim($model->email)) {
                $model->addError('email', '邮箱不可为空');
            }
            if (!trim($model->password_hash)) {
                $model->addError('password_hash', '密码不可为空');
            }
            if (!\common\base\Helper::getInstance()->isEmail($model->email)) {
                $model->addError('email', '邮箱格式不正确');
            }
            $userName = \common\base\User::getInstance()->getByUserName($model->username);
            if ($userName && $userName['id'] != $id) {
                $model->addError('username', '用户名已经存在');
            }
            $email = \common\base\User::getInstance()->getByEmail($model->email);
            if ($email && $email['id'] != $id) {
                $model->addError('email', '邮箱已经存在');
            }
            if ($model->getErrors()) {
                return $this->render('update', ['model' => $model]);
            }
            $model->setPassword($model->password_hash);
            $model->generateAuthKey();
            $model->updated_at = time();
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * 删除管理员用户
     * @param int $id 管理员ID
     * @return string
     */
    public function actionDelete($id)
    {
        $count = \common\models\User::updateAll(['status' => \common\base\Status::Delete], ' `id` = :id AND `status` != 9', [
            ':id' => intval($id),
        ]);
        return $count > 0 ? 'yes' : 'no';
    }

    /**
     * 用户详情
     * @param int $id 用户主键ID
     * @return null|static
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getById($id)
    {
        $model = \common\models\User::findOne(intval($id));
        if ($model !== null) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }
}

<?php

namespace backend\controllers;


class MenuController extends Base
{
    public function actionIndex()
    {
        $query = \common\models\Menu::find();
        $request = \Yii::$app->getRequest()->get();
        unset($request['r']);
        if ($request) {

        }

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
     * 添加分类
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new \common\models\Menu();
        $model->status = 1;
        if (\Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(\Yii::$app->getRequest()->post())) {
                return $this->render('create', ['model' => $model]);
            }
            $model->pid = ($model->pid == 1 ? 0 : $model->pid);

            $model->ctime = $model->utime = time();
            if (!$model->getErrors() && $model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * 编辑分类
     * @param int $id 分类ID
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->getById($id);
        if (\Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(\Yii::$app->getRequest()->post())) {
                return $this->render('update', ['model' => $model]);
            }
            $model->pid = ($model->pid == 1 ? 0 : $model->pid);

            $model->utime = time();
            if (!$model->getErrors() && $model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * 删除菜单
     * @param int $id 菜单ID
     * @return string
     */
    public function actionDelete($id)
    {
        $count = \common\models\Menu::updateAll(['status' => 9, 'ctime' => time()], ' `id` = :id AND `status` != :status', [
            ':id' => intval($id),
            ':status' => \common\base\Status::Delete,
        ]);
        return $count > 0 ? 'yes' : 'no';
    }

    /**
     * 通过ID获取菜单详情
     * @param int $id 菜单ID
     * @return null|static
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getById($id)
    {
        $model = \common\models\Menu::findOne(intval($id));
        if ($model !== null) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException('The requested pages does not exist.');
    }
}

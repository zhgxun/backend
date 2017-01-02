<?php

namespace backend\controllers;

class LinkController extends Base
{
    /**
     * 友情链接
     * @return string
     */
    public function actionIndex()
    {
        $query = \common\models\Link::find();
        $query->where(' `status` != :status', [
            ':status' => \common\base\Status::Delete,
        ]);
        $request = \Yii::$app->getRequest()->get();
        unset($request['r']);
        if ($request) {
            if (isset($request['title']) && trim($request['title'])) {
                $query->andWhere(' `title` LIKE :title', [
                    ':title' => '%' . trim(strip_tags($request['title'])) . '%',
                ]);
            }
            if (isset($request['url']) && trim($request['url'])) {
                $query->andWhere(' `url` LIKE :url', [
                    ':url' => '%' . trim(strip_tags($request['url'])) . '%',
                ]);
            }
            if (isset($request['status']) && intval($request['status'])) {
                $query->andWhere(' `status` = :current', [
                    ':current' => intval($request['status']),
                ]);
            }
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
     * 友情链接详情
     * @param int $id 记录ID
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->getById($id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * 添加友情链接
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new \common\models\Link();
        $model->status = 1;
        if (\Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(\Yii::$app->getRequest()->post())) {
                return $this->render('create', ['model' => $model]);
            }
            $model->ctime = $model->utime = time();
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * 编辑友情链接
     * @param int $id 记录ID
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
            $model->utime = time();
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', ['model' => $model]);
    }

    /**
     * 删除友情链接
     * @param int $id 记录ID
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->getById($id);
        if ($model->status != \common\base\Status::Delete) {
            $model->status = \common\base\Status::Delete;
            $model->utime = time();
            if ($model->save()) {
                return 'yes';
            }
        }
        return 'no';
    }

    /**
     * 友情链接对象
     * @param int $id 记录ID
     * @return null|object|array
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getById($id)
    {
        $model = \common\models\Link::findOne(intval($id));
        if ($model !== null) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }
}

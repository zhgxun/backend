<?php

namespace backend\controllers;

class RecommendController extends Base
{
    /**
     * 推荐列表
     * @return string
     */
    public function actionIndex()
    {
        $query = \common\models\Recommend::find();
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
            if (isset($request['source']) && trim($request['source'])) {
                $query->andWhere(' `source` LIKE :source', [
                    ':source' => '%' . trim(strip_tags($request['source'])) . '%',
                ]);
            }
            if (isset($request['type']) && intval($request['type'])) {
                $query->andWhere(' `type` = :type', [
                    ':type' => intval($request['type']),
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
     * 添加推荐
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new \common\models\Recommend();
        $model->type = 1;
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
     * 编辑推荐
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
     * 删除推荐
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
     * 推荐对象
     * @param int $id 记录ID
     * @return null|static
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getById($id)
    {
        $model = \common\models\Recommend::findOne(intval($id));
        if ($model !== null) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }
}

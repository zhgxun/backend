<?php

namespace backend\controllers;

class SentenceController extends Base
{
    /**
     * 每日一语整理
     * @return string
     */
    public function actionIndex()
    {
        $query = \common\models\Sentence::find();
        $query->where(' `status` != 9');
        $request = \Yii::$app->getRequest()->get();
        unset($request['r']);
        if ($request) {
            if (isset($request['title']) && trim($request['title'])) {
                $query->andWhere(' `title` LIKE :title', [
                    ':title' => '%' . trim(strip_tags($request['title'])) . '%',
                ]);
            }
            if (isset($request['author']) && trim($request['author'])) {
                $query->andWhere(' `author` LIKE :author', [
                    ':author' => '%' . trim(strip_tags($request['author'])) . '%',
                ]);
            }
            if (isset($request['quote']) && trim($request['quote'])) {
                $query->andWhere(' `quote` LIKE :quote', [
                    ':quote' => '%' . trim(strip_tags($request['quote'])) . '%',
                ]);
            }
            if (isset($request['status']) && intval($request['status'])) {
                $query->andWhere(' `status` = :status', [
                    ':status' => intval($request['status']),
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
     * 创建每日一语
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new \common\models\Sentence();
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
     * 编辑每日一语
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
     * 删除每日一语
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
     * 每日一语对象
     * @param $id
     * @return null|object|array
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getById($id)
    {
        $model = \common\models\Sentence::findOne(intval($id));
        if ($model !== null) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }
}
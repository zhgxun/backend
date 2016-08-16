<?php

namespace backend\controllers;

class NavigationController extends Base
{
    public function actionIndex()
    {
        $query = \common\models\Navigation::find();
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

    public function actionCreate()
    {
        $model = new \common\models\Navigation();
        $model->status = 1;
        if (\Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(\Yii::$app->getRequest()->post())) {
                return $this->render('create', ['model' => $model]);
            }
            $model->ctime = $model->utime = time();
            if (!$model->getErrors() && $model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->getById($id);
        if (\Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(\Yii::$app->getRequest()->post())) {
                return $this->render('update', ['model' => $model]);
            }
            $model->ctime = $model->utime = time();
            if (!$model->getErrors() && $model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $count = \common\models\Navigation::updateAll(['status' => 9, 'utime' => time()], ' `id` = :id AND `status` != 9', [
            ':id' => intval($id),
        ]);
        return $count > 0 ? 'yes' : 'no';
    }

    protected function getById($id)
    {
        $model = \common\base\Navigation::getInstance()->getById($id);
        if ($model) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }
}

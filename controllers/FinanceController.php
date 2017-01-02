<?php

namespace backend\controllers;

class FinanceController extends Base
{
    public function actionIndex()
    {
        $query = \common\models\Finance::find();
        $query->where(' `status` != :status', [
            ':status' => \common\base\Status::Delete,
        ]);
        $request = \Yii::$app->getRequest()->get();
        unset($request['r']);
        if ($request) {
            if (isset($request['type']) && intval($request['type'])) {
                $query->andWhere('`type` = :type', [
                    ':type' => intval($request['type']),
                ]);
            }
            if (isset($request['name']) && trim($request['name'])) {
                $query->andWhere(' `name` LIKE :name', [
                    ':name' => '%' . trim(strip_tags($request['name'])) . '%',
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
     * 添加记录
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new \common\models\Finance();
        $model->status = $model->type = 1;
        if (\Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(\Yii::$app->getRequest()->post())) {
                return $this->redirect(['index']);
            }
            if (!trim($model->name)) {
                $model->addError('name', '项目名称不能为空');
            }
            if (!trim($model->cost)) {
                $model->addError('cost', '消费或收入不能为空');
            }
            if (!trim($model->date) || !strtotime($model->date)) {
                $model->addError('date', '记录日期不正确');
            }
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * 记录更新
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->getById($id);
        if (\Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(\Yii::$app->getRequest()->post())) {
                return $this->render('u[date', ['model' => $model]);
            }
            if (!trim($model->name)) {
                $model->addError('name', '项目名称不能为空');
            }
            if (!trim($model->cost)) {
                $model->addError('cost', '消费或收入不能为空');
            }
            if (!trim($model->date) || !strtotime($model->date)) {
                $model->addError('date', '记录日期不正确');
            }
            $model->utime = date('Y-m-d H:i:s', time());
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', ['model' => $model]);
    }

    /**
     * 删除记录
     * @param $id
     * @return bool
     */
    public function actionDelete($id)
    {
        $int = \common\models\Finance::updateAll(['status' => \common\base\Status::Delete], ' `id` = :id AND `status` = 1', [
            ':id' => intval($id),
        ]);
        return $int > 0 ? 'yes' : 'no';
    }

    /**
     * 记录详情
     * @param $id
     * @return null|object|array
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getById($id)
    {
        $model = \common\models\Finance::findOne(intval($id));
        if ($model !== false) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }
}

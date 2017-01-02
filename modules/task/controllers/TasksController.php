<?php

namespace backend\modules\task\controllers;

use backend\controllers\Base;
use Yii;

/**
 * 任务管理
 */
class TasksController extends Base
{
    /**
     * 任务列表
     * @return mixed
     */
    public function actionIndex()
    {
        $query = \common\models\task\Tasks::find();
        $request = Yii::$app->getRequest()->get();
        unset($request['r']);
        if ($request) {
            if (isset($request['title']) && trim($request['title'])) {
                $query->andWhere(' `title` LIKE :title', [
                    ':title' => '%' . trim(strip_tags($request['title'])) . '%',
                ]);
            }
            if (isset($request['type']) && intval($request['type'])) {
                $query->andWhere(' `type` = :type', [
                    ':type' => intval($request['type']),
                ]);
            }
            if (isset($request['content']) && trim($request['content'])) {
                $query->andWhere(' `content` LIKE :content', [
                    ':content' => '%' . trim(strip_tags($request['content'])) . '%',
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
     * 任务明细
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->getById($id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * 创建任务
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new \common\models\task\Tasks();
        $model->task_type = 'temporary';
        $model->task_status = 'untreated';
        $model->audit_status = 'untreated';
        $hosts = Yii::$app->params['hosts'];
        $branches[] = exec('git branch');
        $dataYearList = Yii::$app->params['dataYear'];
        if (Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(Yii::$app->getRequest()->post())) {
                return $this->render('create', [
                    'model' => $model,
                    'hosts' => $hosts,
                    'branches' => $branches,
                    'dataYearList' => $dataYearList
                ]);
            }
            $model->code_branch = $branches[$model->code_branch];
            $model->ipaddress = $hosts[$model->ipaddress];
            $model->data_year = $dataYearList[$model->data_year];
            $model->user_name = Yii::$app->getUser()->getIdentity()->username;
            $model->ctime = $model->utime = date('Y-m-d H:i:s');
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'hosts' => $hosts,
            'branches' => $branches,
            'dataYearList' => $dataYearList
        ]);
    }

    /**
     * 更新任务
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->getById($id);
        if ($model->task_status != 'untreated' || $model->audit_status != 'untreated') {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $hosts = Yii::$app->params['hosts'];
        $branches[] = exec('git branch');
        $dataYearList = Yii::$app->params['dataYear'];
        if (Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(Yii::$app->getRequest()->post())) {
                return $this->render('update', [
                    'model' => $model,
                    'hosts' => $hosts,
                    'branches' => $branches,
                    'dataYearList' => $dataYearList
                ]);
            }
            $model->code_branch = $branches[$model->code_branch];
            $model->ipaddress = $hosts[$model->ipaddress];
            $model->data_year = $dataYearList[$model->data_year];
            $model->utime = date('Y-m-d H:i:s');
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'hosts' => $hosts,
            'branches' => $branches,
            'dataYearList' => $dataYearList
        ]);
    }

    /**
     * 任务删除
     * @param $id
     * @return string
     */
    public function actionDelete($id)
    {
        $model = $this->getById($id);
        if ($model->status != \common\base\Status::Delete && !in_array($model->task_status, ['init', 'running'])) {
            $model->status = \common\base\Status::Delete;
            $model->utime = time();
            if ($model->save()) {
                return 'yes';
            }
        }
        return 'no';
    }

    /**
     * 任务详情
     * @param $id
     * @return null|object|array
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getById($id)
    {
        $model = \common\models\task\Tasks::findOne(intval($id));
        if ($model !== null) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }
}

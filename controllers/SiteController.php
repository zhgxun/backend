<?php

namespace backend\controllers;

use Yii;

/**
 * 文章管理
 */
class SiteController extends Base
{
    /**
     * 文章列表
     * @return string
     */
    public function actionIndex()
    {
        $query = \common\models\Article::find();
        $query->where(' `status` != :status', [
            ':status' => \common\base\Status::Delete,
        ]);
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
     * 文章详情
     * @param int $id 文章ID
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->getById($id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * 添加文章
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new \common\models\Article();
        $model->type = 1;
        $model->status = 1;
        if (Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(Yii::$app->getRequest()->post())) {
                return $this->render('update', ['model' => $model]);
            }
            $model->userid = Yii::$app->getUser()->getId();
            $model->ctime = $model->utime = time();
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * 编辑文章
     * @param int $id 文章ID
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->getById($id);
        if (Yii::$app->getRequest()->getIsPost()) {
            if (!$model->load(Yii::$app->getRequest()->post())) {
                return $this->render('update', ['model' => $model]);
            }
            $model->userid = Yii::$app->getUser()->getId();
            $model->utime = time();
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * 删除文章
     * @param int $id 文章ID
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
     * 根据文章ID获得文章对象
     * @param $id
     * @return null|static
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getById($id)
    {
        $model = \common\models\Article::findOne(intval($id));
        if ($model !== null) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 上传图片到七牛云存储
     * @return mixed|string
     */
    public function actionUpload()
    {
        // 是否有文件上传
        if (!isset($_FILES['imgFile']) || $_FILES['imgFile']['error'] || !$_FILES['imgFile']['name']) {
            return json_encode(['error' => 1, 'message' => '没有文件被上传']);
        }
        // 扩展名检测
        if (!in_array($_FILES['imgFile']['type'], ['image/jpeg', 'image/png', 'image/gif'])) {
            return json_encode(['error' => 1, 'message' => '扩展名不允许']);
        }
        $filePath = $_FILES['imgFile']['tmp_name']; // 图片上传后保存的临时路径
        $fileName = '/zoulu/article/' . date('ymdHis', time()) . $_FILES['imgFile']['name'];
        if (!file_exists($filePath)) {
            return json_encode(['error' => 1, 'message' => '临时文件不存在']);
        }
        $url = \common\extend\qiniu\Upload::getInstance()->uploadFile($fileName, $filePath);
        if (isset($url['key']) && $url['key']) {
            return json_encode(['error' => 0, 'url' => Yii::$app->params['qiniu']['baseurl'] . $url['key']]);
        } else {
            \common\base\TaskLog::getInstance()->writeLog(\yii\helpers\Json::encode($url));
        }
        unlink($filePath);
        return json_encode(['error' => 1, 'message' => '图片上传到七牛云存储失败']);
    }

    /**
     * 登陆
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->getUser()->getIsGuest()) {
            return $this->goHome();
        }

        $model = new \common\models\LoginForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', ['model' => $model]);
    }

    /**
     * 退出
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout();
        return $this->goHome();
    }
}

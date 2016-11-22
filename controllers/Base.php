<?php

namespace backend\controllers;

use yii\web\Controller;
use Yii;

class Base extends Controller
{
    public $permissionName;
    public $whiteList = [
        '/site/login',
        '/site/logout',
        '/site/error',
        '#',
        '/'
    ];
    public function init()
    {
        parent::init();
        //记录请求详细日志
        $requestLog = [
            'IP]' . \Yii::$app->getRequest()->getUserIP(),
            'Method]' . \Yii::$app->getRequest()->getMethod(),
            'UserHost]' . \Yii::$app->getRequest()->getUserHost(),
            'UserAgent]' . \Yii::$app->getRequest()->getUserAgent(),
            'HostInfo]' . \Yii::$app->getRequest()->getHostInfo(),
            'ReqUri]' . strtolower(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['DOCUMENT_URI']),
            'Get]' . \yii\helpers\Json::encode($_GET),
            'Post]' . \yii\helpers\Json::encode($_POST),
            'rawBody]' . \Yii::$app->getRequest()->getRawBody(),
            'RequestUserID]' . \Yii::$app->getUser()->getId() ? : 0,
        ];
        \common\base\TaskLog::getInstance()->writeLog($requestLog);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'create', 'view', 'update', 'delete',
                            'upload', 'user', 'setrole', 'permission', 'setpermission'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 控制器执行之前进行权限检测
     * @param \yii\base\Action $action
     * @return bool|\yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function beforeAction($action)
    {
        // 如果是文件上传,不验证crsf参数
        if (in_array($action->id, ['upload'])) {
            $this->enableCsrfValidation = false;
        }
        if (!parent::beforeAction($action)) {
            return false;
        }
        // 游客 状态为10 是遵循框架实现机制,即是激活状态
        if (!Yii::$app->getUser()->getIsGuest() && Yii::$app->getUser()->getIdentity()['status'] != 10) {
            throw new \yii\web\ForbiddenHttpException('permission deny.');
        }
        if (\common\base\Menu::getInstance()->root()) {
            return true;
        }
        $this->permissionName = \common\base\Menu::getInstance()->getPermissionName($action);
        if (in_array($this->permissionName, $this->whiteList)) {
            return true;
        }
        if (\common\base\Menu::getInstance()->checkAccess($this->permissionName)) {
            return true;
        }
        throw new \yii\web\ForbiddenHttpException('_error');
    }

    /**
     * 执行成功过后返回
     * @param \yii\base\Action $action 一堆请求信息
     * @param mixed $result 相应地数据内容
     * @return mixed
     */
    public function afterAction($action, $result)
    {
        $ret = parent::afterAction($action, $result);
        return $ret;
    }
}

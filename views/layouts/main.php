<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);

// Bootstrap默认支持两级菜单,增加该样式显示第三级
$this->registerCss('
    .nav .dropdown-submenu  { position:relative; }
    .nav .dropdown-submenu:hover > .dropdown-menu { display:block; top:5px; left:120px; right:auto; }
');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '小步文章发布系统',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
//    $menuItems = [
//        ['label' => '文章', 'url' => ['/site/index']],
//        ['label' => '每日一语', 'url' => ['/sentence/index']],
//        ['label' => '推荐阅读', 'url' => ['/recommend/index']],
//        ['label' => '友情链接', 'url' => ['/link/index']],
//    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '登陆', 'url' => ['/site/login']];
    } else {
        $menuItems = \common\base\Menu::getInstance()->getMenuListKV();
        $menuItems[] = [
            'label' => '退出 (' . Yii::$app->user->identity['username'] . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left"><small>&copy; 2015 -  <?= date('Y') ?> 小步文章发布系统</small></p>

        <p class="pull-right"><small><?= Yii::powered() ?></small></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

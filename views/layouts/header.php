<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">
    <!--    ' . Yii::$app->name . '-->
    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg"><img src="http://babeltime.com/Assets/Babeltime/images/public/logo_babel.png" width="138" height="35"></span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-asterisk"></i><?=Yii::$app->item->title?>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">切换项目: </li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <?php
                                    foreach(Yii::$app->getSites() as $site){
                                        echo Html::a(' <i class="fa fa-users text-aqua"></i>'.$site->title, ['/site/change', 'id'=>$site->id], ['data-method'=>'post']);
                                    }
                                    ?>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown user user-menu">
                    <a href="<?=\yii\helpers\Url::to(['/admin/user/view', 'id'=>\Yii::$app->user->identity->getId()])?>" >
                        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?=Yii::$app->user->identity->username?></span>
                    </a>

                </li>

                <li class="dropdown user user-menu">
                    <?= Html::a(
                        '退出登录',
                        ['/site/logout'],
                        ['data-method' => 'post', 'class' => 'dropdown-toggle pull-right']
                    ) ?>
                </li>
            </ul>
        </div>
    </nav>
</header>

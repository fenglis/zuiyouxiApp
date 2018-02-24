<?php 
	use yii\bootstrap\Nav;
	use mdm\admin\components\MenuHelper; 
	use mdm\admin\components\Helper;
?>
<aside class="main-sidebar">

    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?php
        $callback = function($menu) {
            $data = json_decode($menu['data'], true);
            $items = $menu['children'];
            $return = [
                'label' => $menu['name'],
                'url' => [$menu['route']],
            ];
            //处理我们的配置
            //填写json数据{"icon": "fa fa-user", "visible": false}，其中icon代表列表前面的小图标；
            //visible表示是否显示，值false表示隐藏，不填或者填true表示显示
            if ($data) {
                //visible
                isset($data['visible']) && $return['visible'] = $data['visible'];
                //icon
                isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon'];
                //other attribute e.g. class...
                $return['options'] = $data;
            }
            //没配置图标的显示默认图标
            (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'circle-o';
            $items && $return['items'] = $items;

            return $return;
        }

        ?>
        <?= dmstr\widgets\Menu::widget([
            'options' => ['class' => 'sidebar-menu'],
            'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id,null, $callback, true),
        ]); ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
//                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
//                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
//                    [
//                        'label' => 'Same tools',
//                        'icon' => 'share',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
//                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
//                    [
//                        'label' => '权限管理',
//                        'icon' => 'circle-o',
//                        'url' => 'javascript:;',
//                        'items' => [
//                            ['label' => '用户列表', 'icon' => 'fa fa-circle-o', 'url' => '/admin/user'],
//                            ['label' => '路由管理', 'icon' => 'fa fa-circle-o', 'url' => '/admin/route'],
//                            ['label' => '权限管理', 'icon' => 'fa fa-circle-o', 'url' => '/admin/permission'],
//                            ['label' => '角色管理', 'icon' => 'fa fa-circle-o', 'url' => '/admin/role'],
//                            ['label' => '用户与角色', 'icon' => 'fa fa-circle-o', 'url' => '/admin/assignment'],
//                            ['label' => '菜单管理', 'icon' => 'fa fa-circle-o', 'url' => '/admin/menu'],
//                        ],
//                    ],
                ],
            ]
        ) ?>


    </section>

</aside>

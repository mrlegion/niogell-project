<?php


use app\modules\admin\models\User;
use app\modules\admin\widgets\LeftMenu;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $directoryAsset string */
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?= $directoryAsset ?>/img/AdminLTELogo.png" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <?php
                $user = User::findOne(Yii::$app->user->getId());
                if ($user) {
                    echo '<a href="' . Url::to(['profile/view', 'id' => $user->getId()]) . '" class="d-block">' . $user->username . '</a>';
                } else {
                    echo '<a href="' . Url::to(['site/login']) . '" class="d-block">Guest</a>';
                }
                ?>

            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?= LeftMenu::widget([
                    'header' => 'CONTROL',
                    'items' => [
                        [
                            'icon'  => 'fas fa-circle',
                            'title' => 'Votes',
                            'link'  => ['vote/index'],
                        ],
                    ],
                ]) ?>

                <?php if (Yii::$app->user->can('develop')): ?>
                <li class="nav-item">
                    <a href="<?= Url::to(['rbac/index']) ?>" class="nav-link">
                        <i class="fas fa-user nav-icon"></i>
                        <p>RBAC controll</p>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (Yii::$app->user->can('develop')): ?>
                    <?= LeftMenu::widget([
                        'header' => 'DEVELOP',
                        'items' => [
                            [
                                'icon'  => 'fas fa-tachometer-alt',
                                'title' => 'Gii panel',
                                'link'  => ['/gii'],
                            ],
                            [
                                'icon'  => 'far fa-user',
                                'title' => 'Users accounts',
                                'link'  => ['user/index'],
                            ],
                            [
                                'title' => 'Rbac controll',
                                'icon'  => 'fas fa-archive',
                                'link'  => ['rbac/index'],
                            ],
                            [
                                'title' => 'Add vote',
                                'icon' => 'fas fa-plus',
                                'link' => ['vote/add']
                            ],
                            [
                                'title' => 'Add range vote',
                                'icon' => 'fas fa-plus',
                                'link' => ['vote/add']
                            ],
                        ],

                    ]) ?>

                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
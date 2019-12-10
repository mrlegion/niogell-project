<?php

use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $directoryAsset string */
?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <?= Html::a(Yii::t('layouts', 'Home'), ['site/index'], ['class' => 'nav-link']) ?>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <?= Html::a(Yii::t('layouts', 'Contact'), ['site/contact'], ['class' => 'nav-link']) ?>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <?= Html::a(Yii::t('layouts', 'About'), ['site/about'], ['class' => 'nav-link']) ?>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <?= Html::a(Yii::t('layouts', 'Gii'), ['/gii'], ['class' => 'nav-link']) ?>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="<?=Yii::t('layouts','Search')?>" aria-label="<?=Yii::t('layouts','Search')?>">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">3 <?=Yii::t('layouts','Notifications')?></span>

                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new votes
                    <span class="float-right text-muted text-sm">1 days</span>
                </a>

                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item dropdown-footer"><?=Yii::t('layouts','See All Notifications')?></a>
            </div>
        </li>
        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['site/logout'], ['class' => 'nav-link', 'data-toggle' => 'tooltip', 'title' => Yii::t('layouts','Logout')]) ?>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
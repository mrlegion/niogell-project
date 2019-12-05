<?php

use app\assets\AdminLteAsset;
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $content string */

// ! register assets
AdminLteAsset::register($this);
AppAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

?>

<?php $this->beginPage(); ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head(); ?>
</head>
<body class="hold-transition sidebar-mini">
<?php $this->beginBody(); ?>

<div class="wrapper">
    <?= $this->render('header', compact('directoryAsset')) ?>
    <?= $this->render('left', compact('directoryAsset')) ?>
    <?= $this->render('content', compact('directoryAsset', 'content')) ?>
</div>

<?= $this->render('footer') ?>
<?php $this->endBody(); ?>
</body>
</html>

<?php $this->endPage(); ?>

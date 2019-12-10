<?php

/* @var $this yii\web\View */

$this->title = 'Vote project';

use yii\helpers\Html; ?>

<div class="row">
    <div class="col-12">
        <div class="vcontainer">
            <?= Html::a('Go to registration', ['site/voting'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>

<?php

use yii\helpers\Html;
use yii\web\View;


/* @var $this View */

$this->title = 'Options control panel';
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?= Html::a('<i class="fas fa-plus"></i> Create', ['option/create-category'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>

<?php

/* @var $this \yii\web\View */
/* @var $exception \Exception|null */
/* @var $name int|mixed */
/* @var $message string */


use yii\helpers\Html; ?>

<div class="error-page">
    <h2 class="headline text-warning"> <?= Yii::$app->response->getStatusCode() ?></h2>

    <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! <?= Yii::$app->response->statusText ?></h3>

        <p>
            <?= $message ?>
        </p>

        <form class="search-form">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search">

                <div class="input-group-append">
                    <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <!-- /.input-group -->
        </form>
    </div>
    <!-- /.error-content -->
</div>
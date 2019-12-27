<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;



/* @var $this View */
/* @var $email array|mixed */

$this->title = 'Success register on site!';

?>

<div class="row">
    <div class="col-12">
        <div class="text-center">
            <h2>Success register</h2>
            <h4>You need to confirm your email</h4>
            <br>
            <p>To your mail <b>(<?= $email ?>)</b> sent an email with a link. <br>Go through it to confirm your mail.</p>
            <br>
            <?= Html::a('Resend email', ['site/resend', 'email' => $email], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>

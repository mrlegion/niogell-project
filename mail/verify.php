<?php

use app\models\Vote;

/* @var $model Vote*/

$confirm_link = Yii::$app->urlManager->createAbsoluteUrl(['site/email-confirm', 'token' => $model->verify_token]);
?>

<h2>Hello!</h2>
<p>Thank you for joining.
    Right now it’s important to confirm your email address - so that before the election we can send you an email
    and let you know who to vote for. Only by uniting can we defeat the monopoly of United Russia.</p>
<br>
<p>To confirm the address, simply click on <a href="<?= $confirm_link ?>">this link</a>.</p>i
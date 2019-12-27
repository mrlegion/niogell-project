<?php

use app\modules\admin\models\LoginForm;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model LoginForm */

?>

<div class="login-box">
    <div class="login-logo">
        <?= \yii\bootstrap\Html::a('<b>Vote site</b>', ['/site/index']) ?>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <?php $form = ActiveForm::begin(); ?>

            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Username" name="LoginForm[username]">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Password" name="LoginForm[password]">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="LoginForm[remember]">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <?= \yii\bootstrap4\Html::submitButton('Sign In', ['class' => 'btn btn-primary btn-block']) ?>
                </div>
                <!-- /.col -->
            </div>

            <?php ActiveForm::end(); ?>

            <div class="social-auth-links text-center mb-3">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-primary">
                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                </a>
                <a href="#" class="btn btn-block btn-danger">
                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                </a>
            </div>
            <!-- /.social-auth-links -->

            <p class="mb-1">
                <a href="forgot-password.html">I forgot my password</a>
            </p>
            <p class="mb-0">
                <a href="register.html" class="text-center">Register a new membership</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>

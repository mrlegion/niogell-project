<?php

use app\models\VoteForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;


/* @var $this View */
/* @var $model VoteForm */

$this->title = 'Vote for you favorite deputy';

?>

<?php if (Yii::$app->session->hasFlash('EmailError')) : ?>
    <section class="alert">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="alert-block alert-danger">
                        <h2><?= Yii::t('app', 'Error on registration') ?></h2>
                        <p><?= Yii::$app->session->getFlash('EmailError') ?></p>
                    </div>
                </div>
            </div>
        </div>

    </section>
<?php endif; ?>

    <div class="row">
        <div class="col-12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>
<?php $form = ActiveForm::begin(); ?>
    <!--    user info-->
    <div class="row">
        <div class="col-12 col-sm-6">
            <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
        </div>
        <div class="col-12 col-sm-6">
            <?= $form->field($model, 'phone')->textInput(['type' => 'phone']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?= $form->field($model, 'age')
                ->radioList([
                    '1' => 'Less 18',
                    '2' => '18 - 24',
                    '3' => '25 - 29',
                    '4' => '30 - 39',
                    '5' => '40 - 49',
                    '6' => '50 - 59',
                    '7' => '60+',
                ]) ?>
        </div>
    </div>
    <!--    address info-->
    <div class="row">
        <div class="col-md-6 col-12 col-sm-6 col-lg-3">
            <?= $form->field($model, 'state') ?>
        </div>
        <div class="col-md-6 col-12 col-sm-6 col-lg-3">
            <?= $form->field($model, 'city') ?>
        </div>
        <div class="col-md-6 col-12 col-sm-6 col-lg-3">
            <?= $form->field($model, 'street') ?>
        </div>
        <div class="col-md-6 col-12 col-sm-6 col-lg-3">
            <?= $form->field($model, 'home') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h5>Do you know your deputy? If yes, then write who he is:</h5>
            <?= $form->field($model, 'text')->textarea(['row' => 5, 'placeholder' => 'A certain description of the deputy in all colors'])->label(false) ?>
            <h5>How do you evaluate his work on a scale of 1 to 10, where 1 - does not suit at all, and 10 - suits
                everything</h5>
            <?= $form->field($model, 'rating')->inline(true)
                ->radioList([
                    '1'  => '1',
                    '2'  => '2',
                    '3'  => '3',
                    '4'  => '4',
                    '5'  => '5',
                    '6'  => '6',
                    '7'  => '7',
                    '8'  => '8',
                    '9'  => '9',
                    '10' => '10',
                ])->label(false) ?>
            <?= $form->field($model, 'team')->checkbox()->label('I give my consent to the processing of my personal data in the amount and on the conditions determined by the Regulation and the offer') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?= \yii\bootstrap4\Html::submitButton('Send', ['class' => 'btn btn-primary pull-left']) ?>
            <?= \yii\bootstrap4\Html::a('Cancel', Url::home(), ['class' => 'btn btn-danger pull-right']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
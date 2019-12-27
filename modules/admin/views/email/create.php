<?php

use app\modules\admin\models\EmailForm;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $model EmailForm */

$this->title = Yii::t('email', 'Create new email template');
$this->params['Breadcrumbs'] = Yii::t('email','Create email template');

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?= $this->render('_form', compact('model')) ?>
            </div>
        </div>
    </div>
</div>

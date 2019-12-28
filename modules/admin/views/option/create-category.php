<?php

use app\modules\admin\models\CategoryForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;


/* @var $this View */
/* @var $categories array */
/* @var $optionForm CategoryForm */

$this->title = Yii::t('option', 'Added new Category into Options');
$this->params['Breadcrumbs'] = $this->title;

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <p>Select category or create uniq</p>
                <p>After entered name for this category and click save button</p>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($optionForm, 'name')->textInput() ?>
                <?= $form->field($optionForm, 'category')->dropDownList($categories, ['disabled' => empty($categories) ]) ?>
                <?= $form->field($optionForm, 'isRoot')->checkbox(['disabled' => empty($categories)]) ?>
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Cancel', ['option/index'], ['class' => 'btn btn-danger float-right']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>


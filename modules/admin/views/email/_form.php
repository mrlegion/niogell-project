<?php

use app\modules\admin\models\EmailForm;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;


/* @var $this View */
/* @var $model EmailForm */


$form = ActiveForm::begin();
?>

<?= $form->field($model, 'title')->textInput() ?>
<?= $form->field($model, 'text')->widget(CKEditor::class, [
    'editorOptions' => [
        'preset' => 'full',
        'inline' => false,
    ],
]) ?>
<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
<?= Html::a('Cancel', ['email/index'], ['class' => 'btn btn-danger pull-right']) ?>

<?php ActiveForm::end(); ?>


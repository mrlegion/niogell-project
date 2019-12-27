<?php

use app\modules\admin\models\Email;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;


/* @var $this View */
/* @var $model ActiveDataProvider */

$this->title = Yii::t('email', 'Email templates');
$this->params['Breadcrumbs'] = Yii::t('email', 'Email templates');

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><?= Html::encode($this->title) ?></div>
            <div class="card-body">
                <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $model,
                    'tableOptions' => [
                        'class' => 'table table-bordered table-hover dataTable',
                    ],
                    'columns'      => [
                        [
                            'class' => SerialColumn::class,
                        ],
                        'title',
                        [
                            'attribute' => 'created_at',
                            'format'    => 'html',
                            'content'   => function ($item) {
                                /* @var $item Email */
                                return $item->getCreatedAt();
                            },
                        ],
                        [
                            'attribute' => 'updated_at',
                            'format'    => 'html',
                            'content'   => function ($item) {
                                /* @var $item Email */
                                return $item->getUpdatedAt();
                            },
                        ],
                        [
                            'class' => ActionColumn::class,
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

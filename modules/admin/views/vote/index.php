<?php

use app\models\Vote;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;


/* @var $this View */
/* @var $dataProvider ActiveDataProvider */


?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Vote information</h4>
            </div>
            <div class="card-body">
                <?php Pjax::begin(['enablePushState' => false]); ?>
                <?= GridView::widget([
                    'id' => 'vote-container',
                    'dataProvider' => $dataProvider,
                    'tableOptions' => [
                        'class' => 'table table-bordered table-hover dataTable',
                    ],
                    'columns' => [
                        [
                            'class' => SerialColumn::class,
                        ],
                        'email',
                        'phone',
                        [
                            'label' => 'Address',
                            'format' => 'raw',
                            'content' => function ($item) {

                                /** @var Vote $item */
                                return $item->getAddress();
                            }
                        ],
                        [
                            'attribute' => 'age',
                            'format' => 'html',
                            'content' => function ($item) {
                                /* @var Vote $item */
                                return $item->getAgeTitle();
                            }
                        ],
                        [
                            'attribute' => 'rating',
                            'format' => 'html',
                            'content' => function ($item) {
                                /* @var Vote $item */
                                return $item->getRatingTitle();
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'html',
                            'content' => function ($item) {
                                /* @var Vote $item */
                                return $item->getStatus();
                            }
                        ],
                        'text',
                        [
                            'class' => ActionColumn::class,
                            'buttons' => [
                                'delete' => function ($url, $model) {
                                    return Yii::$app->user->can('vote_delete')
                                        ? Html::a('<i class="fas fa-trash"></i>', '#',
                                        [
                                            'class' => 'btn btn-danger',
                                            'data-type' => 'delete-btn',
                                            'data-vote-id' => $model->id,
                                        ])
                                        : '';
                                },
                                'send' => function ($url, $model) {
                                    return Html::a('<i class="fas fa-envelope"></i>', ['vote/send'], ['class' => 'btn btn-primary']);
                                },
                            ],
                            'template' => '{send} {delete}'
                        ]

                    ],
                    'options' => [
                        'class' => 'dataTables_wrapper dt-bootstrap4',
                    ],
                ]) ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

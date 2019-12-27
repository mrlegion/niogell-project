<?php

namespace app\modules\admin\controllers;

use yii\filters\AccessControl;

class UserController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['*'],
                        'roles' => ['admin']
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        return $this->render('create');
    }

    public function actionView(int $id)
    {
        return $this->render('view');
    }

    public function actionUpdate(int $id)
    {
        return $this->render('update');
    }

    public function actionDelete(int $id)
    {
        return $this->render('delete');
    }
}

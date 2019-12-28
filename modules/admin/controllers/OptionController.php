<?php


namespace app\modules\admin\controllers;


use yii\filters\AccessControl;
use yii\web\Controller;

class OptionController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'save'],
                        'roles'   => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['superuser'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionSave()
    {

    }

    public function actionCreateCategory()
    {
        return $this->render('create-category');
    }

    public function actionCreateOption()
    {

    }
}
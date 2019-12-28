<?php


namespace app\modules\admin\controllers;


use app\modules\admin\models\CategoryForm;
use app\modules\admin\models\OptionForm;
use app\modules\admin\models\OptionTitle;
use yii\di\Container;
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
        // todo: need create form for editing options value

        return $this->render('index');
    }

    public function actionSave()
    {
        if (\Yii::$app->request->isPost) {
            // todo: create logic for saved changed options
        }
        return $this->redirect(['option/index']);
    }

    public function actionCreateCategory()
    {
        $optionForm = new CategoryForm();

        // get post params
        if (\Yii::$app->request->isPost) {
            // todo: create logic for adding new record in db
            if ($optionForm->load(\Yii::$app->request->post()) && $optionForm->validate()) {
                if ($optionForm->save()) {
                    return $this->redirect(['option/index']);
                }
            }
        }

        $categories = OptionTitle::getCategories();

        return $this->render('create-category', compact('optionForm', 'categories'));
    }

    public function actionCreateOption()
    {

    }
}
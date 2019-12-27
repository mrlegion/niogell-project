<?php


namespace app\modules\admin\controllers;


use yii\web\Controller;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (\Yii::$app->user->isGuest) {
                \Yii::$app->user->loginUrl = ['auth/login'];
                return $this->redirect(\Yii::$app->user->loginUrl);
            }
        }
        return parent::beforeAction($action);
    }

}
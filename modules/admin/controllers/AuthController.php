<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\LoginForm;
use Yii;
use yii\helpers\Url;

class AuthController extends \yii\web\Controller
{
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['vote/index']);
        }

        $model = new LoginForm();
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->login()) {
                    return $this->redirect(['vote/index']);
                }
            }
        }

        return $this->render('login', compact('model'));
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['auth/login']);
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception, 'name' => $exception->getCode(), 'message' => $exception->getMessage()]);
        }
    }
}
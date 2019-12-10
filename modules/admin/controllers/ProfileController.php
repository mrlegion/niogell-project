<?php

namespace app\modules\admin\controllers;

class ProfileController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}

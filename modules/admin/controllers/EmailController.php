<?php


namespace app\modules\admin\controllers;


use app\modules\admin\models\Email;
use app\modules\admin\models\EmailForm;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\web\Controller;

class EmailController extends Controller
{


    public function actionIndex()
    {
        $model = new ActiveDataProvider([
            'query'      => Email::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', compact('model'));
    }

    public function actionCreate()
    {
        $model = new EmailForm();

        if (\Yii::$app->request->isPost) {
            // todo: create logic for adding email template in database
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->save()) {
                    return $this->redirect(['email/index']);
                }
            }
        }

        return $this->render('create', compact('model'));
    }

    public function actionView(int $id)
    {
        $model = Email::findOne(['id' => $id]);

        return $this->render('view', compact('model'));
    }

    public function actionUpdate(int $id)
    {
        $model = Email::findOne(['id' => $id]);
        if (\Yii::$app->request->isPost) {
            // todo: create logic for update record in database
        }
        return $this->render('update', compact('model'));
    }

    /**
     * @param int $id
     * @return \yii\web\Response
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function actionDelete(int $id)
    {
        try {
            Email::findOne(['id' => $id])->delete();
        } catch (StaleObjectException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw $e;
        }
        return $this->redirect('email/index');
    }
}
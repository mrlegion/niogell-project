<?php

namespace app\controllers;

use app\models\MailService;
use app\models\RegisterService;
use app\models\Vote;
use app\models\VoteForm;
use RuntimeException;
use Yii;
use yii\base\ExitException;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return parent::behaviors();
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionVoting()
    {
        $model = new VoteForm();

        // check on POST request
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                try {
                    $service = new RegisterService();
                    $service->singup($model);
                    Yii::$app->session->setFlash('RegisterSuccess', 'Check your email to confirm the registration.');
                    return $this->redirect(['site/success', 'email' => $model->email]);
                } catch (\Exception $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('RegisterError', $e->getMessage());
                    throw $e;
                }
            }
        }

        return $this->render('voting', compact('model'));
    }

    // ! There is no action on pressing the button to resend the message
    public function actionSuccess()
    {
        // TODO: Make a method to resend a message to a user
        return $this->render('success', ['email' => Yii::$app->request->get('email')]);
    }

    public function actionResend(string  $email)
    {
        $vote = Vote::findByEmail($email);
        if ($vote && $vote->status === Vote::INACTIVE) {
            try {
                // ? Maybe need create method or operation for generate new verify token when we resend email
                // TODO: create method or operation for generate new verify token when we resend email
                // ! Do it wrong. Add Transactions
                $vote->setAttribute('verify_token', Yii::$app->security->generateRandomString());
                MailService::sendEmail($vote);
                $vote->save();
                return $this->redirect(['site/success', 'email' => $vote->email]);
            } catch (\Swift_TransportException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('ResendEmailError', $e->getMessage());
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('ResendEmailError', $e->getMessage());
            }
        }
        return $this->render('error', ['name' => 'Error on resend', 'message' => 'On resend email has error! Please try again later']);
    }

    // ! There is no action on the wrong token from the user
    public function actionEmailConfirm($token)
    {
        // todo: Make two display options (one with successful confirmation, the second with an error)
        $service = new RegisterService();
        try {
            $service->confirmation($token);
        } catch (ExitException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->render('error', ['name' => $e->getCode(), 'message' => $e->getMessage()]);
        }
        return $this->render('email-confirm');
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception, 'name' => $exception->getCode(), 'message' => $exception->getMessage()]);
        }
    }
}

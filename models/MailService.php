<?php

namespace app\models;

use RuntimeException;
use Yii;

class MailService
{
    /**
     * @param Vote $vote
     * @throws \Swift_TransportException
     * @throws \Exception
     */
    public static function sendEmail(Vote $vote)
    {
        try {
            $send = Yii::$app->mailer
                ->compose('verify', ['model' => $vote])
                ->setTo($vote->email)
                ->setFrom(Yii::$app->params['senderEmail'])
                ->setSubject('Confirmation of registration')
                ->send();
            if (!$send) {
                Yii::$app->session->setFlash('EmailError', Yii::t('email', 'Error in send email!'));
                throw new \Exception('Send mail error');
            }
        } catch (\Swift_TransportException $e) {
            Yii::$app->session->setFlash('EmailError', Yii::t('email', 'Wrong email address! Please check entered data'));
            throw $e;
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('EmailError', Yii::t('email', 'Error in send email!'));
            throw $e;
        }
    }
}
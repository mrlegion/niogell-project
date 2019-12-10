<?php

namespace app\models;

use RuntimeException;
use Yii;

class MailService
{
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
                Yii::$app->session->setFlash('EmailError', Yii::t('email', 'Wrong email address! Please check entered data'));
                throw new RuntimeException('Send mail error');
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('EmailError', Yii::t('email', 'Wrong email address! Please check entered data'));
            throw new RuntimeException('Send mail error');
        }
    }
}
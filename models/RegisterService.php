<?php


namespace app\models;


use DomainException;
use RuntimeException;
use yii\base\ExitException;
use yii\web\View;

class RegisterService
{
    /**
     * Sing up new user to system
     *
     * @param VoteForm $form
     * @throws \Exception
     */
    public function singup(VoteForm $form)
    {
        $transaction = Vote::getDb()->beginTransaction();
        try {
            $vote = $form->getVote();

            if ($vote->validate()) {
                if ($vote->save()) {
                    MailService::sendEmail($vote);
                    $transaction->commit();
                }
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * @param string $token
     * @return bool
     * @throws ExitException
     */
    public function confirmation(string $token)
    {
        if (empty($token)) {
            throw new ExitException(89, 'Verify token has empty');
        }
        $vote = Vote::findOne(['verify_token' => $token]);
        if ($vote === null) {
            throw new ExitException(90, 'Verify token for email check is UNDEFINED');
        }

        $transaction = Vote::getDb()->beginTransaction();

        try {
            $vote->setAttribute('verify_token', null);
            $vote->setAttribute('status', Vote::ACTIVE);
            if ($vote->save()) {
                $transaction->commit();
                return true;
            }
            throw new RuntimeException('Saving error.');
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new RuntimeException('Saving error.');
        }
    }
}


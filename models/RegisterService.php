<?php


namespace app\models;


use DomainException;
use RuntimeException;

class RegisterService
{
    /**
     * Sing up new user to system
     *
     * @param VoteForm $form
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
        }
    }

    /**
     * @param string $token
     * @return bool
     */
    public function confirmation(string $token)
    {
        if (empty($token)) {
            throw new DomainException('Empty confirm token.');
        }
        $vote = Vote::findOne(['verify_token' => $token]);
        if (!$vote) {
            throw new DomainException('Vote is not found');
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


<?php


namespace app\models;


use Yii;
use yii\base\Model;

/**
 * This is the model class for VoteForm".
 *
 * @property string $email
 * @property string $phone
 * @property int $age
 * @property string $state
 * @property string $city
 * @property string $street
 * @property string $home
 * @property int $rating
 * @property string|null $text
 */
class VoteForm extends Model
{
    public $email;
    public $phone;
    public $age;
    public $state;
    public $city;
    public $street;
    public $home;
    public $rating;
    public $text;

    /**
     * @var boolean
     */
    public $team;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'phone', 'age', 'state', 'city', 'street', 'home', 'rating'], 'required'],
            ['team', 'boolean'],
            ['team', 'checkAcceptTeam'],
            [['age', 'rating'], 'integer'],
            [['text'], 'string'],
            [['email', 'state', 'city', 'street', 'home'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            ['email', 'checkEmailOnDb'],
        ];
    }

    public function checkEmailOnDb($attribute, $params)
    {
        if (Vote::hasEmail($this->email)) {
            $this->addError($attribute, Yii::t('vote','This email address already register on site. Please select other email or check your email for validate email'));
        }
    }

    public function checkAcceptTeam($attribute, $params)
    {
        if (!$this->team) {
            $this->addError($attribute, Yii::t('vote', 'It is necessary to accept consent to the processing of personal data'));
        }
    }

    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function attributeLabels()
    {
        return [
            'email'        => Yii::t('vote', 'Email'),
            'phone'        => Yii::t('vote', 'Phone'),
            'age'          => Yii::t('vote', 'Age'),
            'state'        => Yii::t('vote', 'State'),
            'city'         => Yii::t('vote', 'City'),
            'street'       => Yii::t('vote', 'Street'),
            'home'         => Yii::t('vote', 'Home'),
            'rating'       => Yii::t('vote', 'Rating'),
            'text'         => Yii::t('vote', 'Text'),
            'verify_token' => Yii::$app->security->generateRandomString(),
        ];
    }

    /**
     * Get Vote model from VoteForm
     * if validation is successful, then the model will return, otherwise null
     *
     * @return Vote|null
     * @throws \yii\base\Exception
     */
    public function getVote()
    {
        $vote = new Vote();

        $vote->setAttributes([
            'email'        => $this->email,
            'phone'        => $this->phone,
            'age'          => $this->age,
            'state'        => $this->state,
            'city'         => $this->city,
            'street'       => $this->street,
            'home'         => $this->home,
            'rating'       => $this->rating,
            'text'         => $this->text,
            'status'       => Vote::INACTIVE,
            'verify_token' => Yii::$app->security->generateRandomString(),
        ]);

        return $vote;
    }


}

<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%vote}}".
 *
 * @property int $id
 * @property string $email
 * @property string $phone
 * @property int $age
 * @property string $state
 * @property string $city
 * @property string $street
 * @property string $home
 * @property int $rating
 * @property string|null $text
 * @property string $verify_token
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Vote extends \yii\db\ActiveRecord
{
    const NONE = 0;
    const INACTIVE = 5;
    const ACTIVE = 10;
    const WAIT = 15;
    const DELETE = 99;

    const AGES = [
        '1' => 'Less 18 year',
        '2' => 'From 18 to 24 year',
        '3' => 'From 25 to 29 year',
        '4' => 'From 30 to 39 year',
        '5' => 'From 40 to 49 year',
        '6' => 'From 50 to 60 year',
        '7' => 'More than 60 years',
    ];

    const RATING = [
        '1'  => 'One star',
        '2'  => 'Two star',
        '3'  => 'Three star',
        '4'  => 'Four star',
        '5'  => 'Five star',
        '6'  => 'Six star',
        '7'  => 'Seven star',
        '8'  => 'Eight star',
        '9'  => 'Nine star',
        '10' => 'Ten star',
    ];

    public function transactions()
    {
        return [
            'default' => self::OP_ALL,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vote}}';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class'      => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'phone', 'age', 'state', 'city', 'street', 'home', 'rating'], 'required'],
            [['age', 'rating', 'status'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['email', 'state', 'city', 'street', 'home', 'verify_token'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('vote', 'ID'),
            'email'        => Yii::t('vote', 'Email'),
            'phone'        => Yii::t('vote', 'Phone'),
            'age'          => Yii::t('vote', 'Age'),
            'state'        => Yii::t('vote', 'State'),
            'city'         => Yii::t('vote', 'City'),
            'street'       => Yii::t('vote', 'Street'),
            'home'         => Yii::t('vote', 'Home'),
            'rating'       => Yii::t('vote', 'Rating'),
            'text'         => Yii::t('vote', 'Text'),
            'verify_token' => Yii::t('vote', 'Verify Token'),
            'status'       => Yii::t('vote', 'Status'),
            'created_at'   => Yii::t('vote', 'Created At'),
            'updated_at'   => Yii::t('vote', 'Updated At'),
        ];
    }

    public function getCreatedAt()
    {
        $date = new \DateTime();
        $date->setTimestamp($this->created_at);
        return $date->format('Y-m-d H:i:s');
    }

    public function getUpdatedAt()
    {
        $date = new \DateTime();
        $date->setTimestamp($this->updated_at);
        return $date->format('Y-m-d H:i:s');
    }

    public static function findByEmail(string $email)
    {
        return self::findOne(['email' => $email]);
    }

    public static function hasEmail(string $email): bool
    {
        return self::findByEmail($email) !== null ? true : false;
    }

    public function getAddress(): string
    {
        return $this->state . ', c.' . $this->city . ', str. ' . $this->street . ', house ' . $this->home;
    }

    public function getAgeTitle(): string
    {
        return self::AGES[$this->age];
    }

    public function getRatingTitle(): string
    {
        $result = '<span style="color: #f39c12">';
        for ($i = 0; $i < $this->rating; $i++) {
            $result .= '<i class="fas fa-star"></i>';
        }
        return $result . '</span>';
    }

    public function getStatus()
    {
        switch ($this->status) {
            case self::ACTIVE:
                return '<span style="color: #27ae60"><b>Active</b></span>';
            case self::INACTIVE:
                return '<span style="color: #e67e22"><b>Inactive</b></span>';
            case self::WAIT:
                return '<span style="color: #e67e22"><b>Wait</b></span>';
            case self::DELETE:
                return '<span style="color: #e74c3c"><b>Deleted</b></span>';
            case self::NONE:
                return '<span style="color: #e74c3c"><b>Error!</b></span>';
        }
    }
}

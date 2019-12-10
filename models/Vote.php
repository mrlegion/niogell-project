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

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
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
    public static function tableName()
    {
        return '{{%vote}}';
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
            [['created_at', 'updated_at'], 'safe'],
            [['email', 'state', 'city', 'street', 'home', 'verify_token'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
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
}

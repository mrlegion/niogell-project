<?php

namespace app\modules\admin\models;

use app\modules\admin\Module;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $email
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string $access_token
 * @property string $auth_key
 * @property string|null $verify_token
 * @property int $is_blocked
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const BLOCKED = 1;
    const UNBLOCKED = 0;
    const DELETED = -1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
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
            [['email', 'username', 'first_name', 'last_name', 'password'], 'required'],
            [['is_blocked'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['email', 'username', 'first_name', 'last_name', 'password', 'access_token', 'auth_key', 'verify_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'email'        => 'Email',
            'username'     => 'Username',
            'first_name'   => 'First Name',
            'last_name'    => 'Last Name',
            'password'     => 'Password',
            'access_token' => 'Access Token',
            'auth_key'     => 'Auth Key',
            'verify_token' => 'Verify Token',
            'is_blocked'   => 'Is Blocked',
            'created_at'   => 'Created At',
            'updated_at'   => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return Yii::$app->security->compareString($this->getAuthKey(), $authKey);
    }

    /**
     * {@inheritdoc}
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
        return true;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
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
}

<?php

namespace app\modules\admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%email}}".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @package app\modules\admin\models
 */
class Email extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%email}}';
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

    public function transactions()
    {
        return [
            'default' => self::OP_ALL,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('vote', 'ID'),
            'title'      => Yii::t('vote', 'Title'),
            'content'    => Yii::t('vote', 'Content'),
            'created_at' => Yii::t('vote', 'Created At'),
            'updated_at' => Yii::t('vote', 'Updated At'),
        ];
    }

    /**
     * Gets Created date in string format
     *
     * @return string
     * @throws \Exception
     */
    public function getCreatedAt()
    {
        $date = new \DateTime();
        $date->setTimestamp($this->created_at);
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Gets updated date in string format
     *
     * @return string
     * @throws \Exception
     */
    public function getUpdatedAt()
    {
        $date = new \DateTime();
        $date->setTimestamp($this->updated_at);
        return $date->format('Y-m-d H:i:s');
    }
}

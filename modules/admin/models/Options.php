<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%options}}".
 *
 * @property int $id
 * @property int|null $title_id
 * @property string $value
 *
 * @property OptionTitle $title
 */
class Options extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%options}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_id'], 'integer'],
            [['value'], 'required'],
            [['value'], 'string', 'max' => 255],
            [['title_id'], 'exist', 'skipOnError' => true, 'targetClass' => OptionTitle::class, 'targetAttribute' => ['title_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('option', 'ID'),
            'title_id' => Yii::t('option', 'Title ID'),
            'value'    => Yii::t('option', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTitle()
    {
        return $this->hasOne(OptionTitle::class, ['id' => 'title_id']);
    }
}

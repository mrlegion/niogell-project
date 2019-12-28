<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "{{%option_title}}".
 *
 * @property int $id
 * @property int $group
 * @property string $name
 *
 * @property Option[] $options
 */
class OptionTitle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%option_title}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'    => Yii::t('option', 'ID'),
            'group' => Yii::t('option', 'Group'),
            'name'  => Yii::t('option', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(Option::class, ['title_id' => 'id']);
    }

    /**
     * @throws NotSupportedException
     */
    public function getCategory()
    {
        /**
         * Use only 1 lvl
         * todo: need create logic for tree settings
         * Example:
         * Settings (its ROOT) -> Email template -> Confirm email template
         * hmm.. maybe need use tree for this, or use only one lvl inside
        */
        throw new NotSupportedException();
    }
}

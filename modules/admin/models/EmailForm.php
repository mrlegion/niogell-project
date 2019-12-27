<?php


namespace app\modules\admin\models;


use yii\base\Model;


/**
 * Class EmailForm
 *
 * @property string $title
 * @property string $text
 * @package app\modules\admin\models
 */
class EmailForm extends Model
{
    public $title;
    public $text;

    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['title', 'text'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return bool
     */
    public function save(): bool {
        $email = new Email();
        $email->setAttributes([
            'title' => $this->title,
            'content' => $this->text,
        ]);
        return $email->validate() && $email->save();
    }
}
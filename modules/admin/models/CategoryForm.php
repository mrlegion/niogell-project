<?php


namespace app\modules\admin\models;


use yii\base\Model;

class CategoryForm extends Model
{
    public $name;
    public $isRoot = true;
    public $category;

    public function rules()
    {
        return [
            ['name', 'required'],
            ['category', 'integer'],
            ['isRoot', 'boolean']
        ];
    }

    public function save()
    {
        $model = new OptionTitle();
        $model->setAttributes([
            'name' => $this->name,
            'group' => $this->isRoot ? -1 : $this->category,
        ]);

        return $model->validate() && $model->save();
    }
}
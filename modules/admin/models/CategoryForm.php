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
            [['name', 'isRoot', 'category'], 'required'],
        ];
    }
}
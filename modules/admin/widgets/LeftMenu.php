<?php


namespace app\modules\admin\widgets;


use yii\base\Widget;
use yii\helpers\Url;

class LeftMenu extends Widget
{
    public $options = [];
    public $items;
    public $header = null;

    protected $template = "<li class='nav-item'><a href='%s' class='nav-link'><i class='nav-icon %s'></i><p>%s</p></a></li>";


    public function init()
    {

    }

    public function run()
    {
        $result = '';
        if ($this->header !== null) {
            $result .= "<li class='nav-header'>" . $this->header . "</li>";
        }
        foreach ($this->items as $item) {
            $result .= vsprintf($this->template, [Url::to($item['link']), $item['icon'], $item['title']]);
        }
        return $result;
    }
}
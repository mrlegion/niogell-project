<?php

namespace app\modules\admin;

use Yii;
use yii\filters\AccessControl;
use yii\i18n\PhpMessageSource;
use yii\web\ErrorHandler;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';
    public $defaultRoute = 'vote';

    /**
     * {@inheritdoc}
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->registerTranslations();

        Yii::configure($this, [
            'components' => [
                'errorHandler' => [
                    'class' => ErrorHandler::class,
                    'errorAction' => '/admin/auth/error'
                ],
            ],
        ]);

        /* @var ErrorHandler $handler */
        $handler = $this->get('errorHandler');
        Yii::$app->set('errorHandler', $handler);
        $handler->register();

    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['admin/*'] = [
            'class'          => PhpMessageSource::class,
            'basePath'       => '@app/messages/',
            'sourceLanguage' => 'en-US',
            'fileMap' => [
                'admin/user' => 'user.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('admin/' . $category, $message, $params, $language);

    }

}

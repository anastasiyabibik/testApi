<?php
namespace common\modules\api;

/**
 * class Module
 * @package namespace common\modules
*/
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'api\modules\api\controllers';

    /**
     * @inheritdoc
    */
    public function init()
    {
        parent::init();
    }
}

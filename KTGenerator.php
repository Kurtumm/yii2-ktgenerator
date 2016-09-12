<?php

namespace yii\ktgenerator;

/**
 * ktgenerator module definition class
 */
class KTGenerator extends \yii\base\Module
{
    public $newFileMode = 0666;
    public $newDirMode = 0777;
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'yii\ktgenerator\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: npr
 * Date: 3/1/2016 AD
 * Time: 4:27 PM
 */

namespace yii\ktgenerator\models;

use yii\base\Model;


class CrudGenerator extends Model
{
    public $modelPath;
    public $modelNamespace;
    public $controllerNamespace;
    public $baseControllerClass = 'yii\web\Controller';
    public $widget;
    public $templates;
    public $viewPath;

    public function attributeLabels()
    {
        return [
            'modelPath'=>'Model Path',
            'modelNamespace'=>'Model Namespace',
            'controllerNamespace'=>'Controller Namespace',
            'baseControllerClass'=>'Base Controller Class',
            'widget'=>'Widget',
            'templates'=>'Templates',
            'viewPath'=>'View Path',
        ];
    }

    public function rules()
    {
        return [
            [['modelPath', 'modelNamespace', 'controllerNamespace'], 'required'],
        ];
    }
}

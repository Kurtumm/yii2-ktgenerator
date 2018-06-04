<?php

namespace yii\ktgenerator\controllers;

use yii\ktgenerator\models\CrudGenerator;
//use yii\gii\generators\crud\Generator;
use yii\ktgenerator\gii\templates\crud\Generator;
use Yii;

class CrudController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new CrudGenerator();
        $tables = [];
        $baseControllerClass = 'yii\web\Controller';

        if (isset($_POST['CrudGenerator'])) {

            $handle = fopen('/tmp/crud_costfit', 'w+');
            fwrite($handle, print_r($_POST['CrudGenerator'], true));
            fclose($handle);

            $model->attributes = $_POST['CrudGenerator'];
            $model->baseControllerClass = $_POST['CrudGenerator']['baseControllerClass'];
            $model->viewPath = $_POST['CrudGenerator']['viewPath'];

            $modelPath = \Yii::getAlias($model->modelPath);
            $modelNameSpace = $model->modelNamespace;
            $controllerNameSpace = $model->controllerNamespace;
            $files = scandir($modelPath);
            foreach ($files as $file) {
                if ($file == '.' || $file == '..' || substr($file, -4, 4) != '.php') {
                    continue;
                }
                $modelName = substr($file, 0, -4);

//                if ($modelName == 'ContactForm' || $modelName == 'LoginForm' || $modelName == 'ModelMaster' || $modelName == 'User')
//                    continue;

                $modelClass = $modelNameSpace . '\\' . $modelName;
                $controllerClass = $controllerNameSpace . '\\' . $modelName . 'Controller';
                $searchModelClass = $modelNameSpace.'\search\\'.$modelName;

                $generator = new Generator();
                $generator->modelClass = $modelClass;
                $generator->controllerClass = $controllerClass;
                $generator->baseControllerClass = $baseControllerClass;
                $generator->searchModelClass = $searchModelClass;
                $generator->templates['backend'] = Yii::getAlias('@vendor/yiisoft/yii2-ktgenerator/gii/templates/crud/bootstrap3');
                $generator->template = 'backend';
                $generator->enablePjax = true;

                if(!empty($_POST['CrudGenerator']['viewPath'])) {
                    $generator->viewPath = $_POST['CrudGenerator']['viewPath'].DIRECTORY_SEPARATOR.$generator->getControllerID();
                } else {
                    /**
                     * viewPath
                     */
                    $viewPaths = explode('\\', $controllerClass);
                    $generator->viewPath = '@'.$viewPaths[0].'/views/'.$generator->getControllerID();
                }

                $fs = $generator->generate();
                $answers = [];
                foreach ($fs as $f) {
                    $answers[$f->id] = 1;
                }

                $result = '';
                if ($generator->save($fs, $answers, $result)) {
                    $tables[] = [
                        'modelClass' => $modelClass,
                        'controllerClass' => $controllerClass,
                        'searchModelClass' => $searchModelClass,
                    ];
                }


            }
        }

        return $this->render('index', compact('model', 'tables', 'baseControllerClass'));
    }

}

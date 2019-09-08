<?php

namespace yii\ktgenerator\controllers;

use yii\gii\CodeFile;
use yii\ktgenerator\models\ModelGenerator;
use Yii;
//use yii\ktgenerator\gii\templates\model\Generator;
use yii\gii\generators\model\Generator;
use yii\ktgenerator\gii\templates\crud\Generator as CrudGenerator;

class ExtendModelController extends \yii\web\Controller
{
    public function actionIndex()
    {
        ini_set('max_execution_time', 300);
        ini_set("memory_limit",-1);

        $model = new Generator();
        $model->db = 'db';
        $tables = [];
        $tmp = null;
        $folderName = '';
        $model->ns = 'frontend\models';
        $model->baseClass = 'common\models';
        if (isset($_POST['Generator'])) {
            $tables = [];
            $connectionName = $_POST['Generator']['db'];
            $model->ns = $_POST['Generator']['ns'];
            $folderName = $_POST['folderName'];
            $model->baseClass = $_POST['Generator']['baseClass'];

            $modelNameSpace = $model->ns . '\\' . $folderName;

            $connection = Yii::$app->{$connectionName};

            $cmd = $connection->createCommand('SHOW TABLES');
            $tbs = $cmd->queryAll();

            foreach ($tbs as $tb) {
                foreach ($tb as $tableName) {
                    $tn = explode('_', $tableName);
                    $tn = array_map('ucwords', $tn);
                    $modelClass = implode('', $tn);

                    //Extend Model
                    $generator2 = new Generator();
                    $generator2->db = $connectionName;
                    $generator2->tableName = $tableName;
                    $generator2->modelClass = $modelClass;
                    $generator2->ns = $modelNameSpace;
                    $generator2->baseClass = $model->baseClass . '\\' . $folderName . '\\' . $modelClass;
                    $generator2->templates['extends'] = Yii::getAlias('@vendor/yiisoft/yii2-ktgenerator/gii/templates/model/extends');
                    $generator2->template = 'extends';
                    $generator2->generateQuery = true;
                    $generator2->queryNs = $modelNameSpace . '\query';
                    $files2 = $generator2->generate();
                    $answers2 = [];
                    foreach ($files2 as $file2) {
                        $answers2[$file2->id] = 1;
                    }
                    $result2 = '';

                    //check file exist
                    if (!file_exists(Yii::getAlias('@' . str_replace('\\', '/',
                                $generator2->ns)) . '/' . $generator2->modelClass . '.php')) {
                        $generator2->save($files2, $answers2, $result2);
                    }

                    if (!file_exists(Yii::getAlias('@' . str_replace('\\', '/', $generator2->ns)) . '/' . 'search')) {
                        @mkdir(Yii::getAlias('@' . str_replace('\\', '/', $generator2->ns)) . '/' . 'search', 0775,
                            true);
                    }

                    //check search model not exist
                    if (!file_exists(Yii::getAlias('@' . str_replace('\\', '/', $generator2->ns)) . '/search/' . $generator2->modelClass . '.php')) {
                        //Search Model
                        $crudGenerator = new CrudGenerator();
                        $crudGenerator->modelClass = 'common\\models\\'.$folderName.'\\'.$modelClass;
                        $crudGenerator->controllerClass = 'common\controllers\\' . $modelClass . 'Controller';;
                        $crudGenerator->baseControllerClass = 'yii\web\Controller\'';
                        $crudGenerator->searchModelClass = $modelNameSpace . '\search\\' . $modelClass;
                        $crudGenerator->templates['backend'] = Yii::getAlias('@vendor/yiisoft/yii2-ktgenerator/gii/templates/crud/bootstrap3');
                        $crudGenerator->template = 'backend';
                        $crudGenerator->enablePjax = true;

                        $fs = $crudGenerator->generate();
                        $ffs = [];
                        $answers = [];
                        foreach ($fs as $k=>$f) {
                            $answers[$f->id] = 1;

                            if($k != 1)
                                $f->operation = CodeFile::OP_SKIP;

                            $ffs[$k] = $f;
                        }

                        $fs = $ffs;
                        $resultCrud = '';
                        $crudGenerator->save($fs, $answers, $resultCrud);
                    }

                    $tables[] = [
                        'baseClass' => $generator2->baseClass,
                        'targetClass' => Yii::getAlias('@' . str_replace('\\', '/',
                                    $generator2->ns)) . '/' . $generator2->modelClass . '.php',
                        'model' => $generator2->modelClass,
                        'searchModel' => isset($crudGenerator->searchModelClass) ? $crudGenerator->searchModelClass : '',
                    ];
                }
            }
        }


        return $this->render('index', compact('model', 'tables', 'tmp', 'folderName'));
    }

}

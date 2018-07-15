<?php

namespace yii\ktgenerator\controllers;

use yii\ktgenerator\models\ModelGenerator;
use Yii;
//use yii\ktgenerator\gii\templates\model\Generator;
use yii\gii\generators\model\Generator;

class ModelController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new Generator();
        $model->db = 'db';
        $model->ns = 'common\models';
        $tables = [];
        $tmp = NULL;
        $folderName = '';

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

                    //Master Model
                    $generator = new Generator();
                    $generator->db = $connectionName;
                    $generator->tableName = $tableName;
                    $generator->modelClass = $modelClass;
                    $generator->ns = $modelNameSpace . '\master';
//                    $generator->baseClass = $modelNameSpace . '\ModelMaster';
                    $generator->baseClass = $model->baseClass;
                    $generator->templates['default'] = Yii::getAlias('@vendor/yiisoft/yii2-ktgenerator/gii/templates/model/default');

                    $tmp = $generator->templates;

                    $files = $generator->generate();
                    $answers = [];
                    foreach ($files as $file) {
                        $answers[$file->id] = 1;
                    }
                    $result = '';

                    //Extend Model
                    $generator2 = new Generator();
                    $generator2->db = $connectionName;
                    $generator2->tableName = $tableName;
                    $generator2->modelClass = $modelClass;
                    $generator2->ns = $modelNameSpace;
                    $generator2->baseClass = $generator->ns . '\\' . $generator->modelClass;
                    $generator2->templates['extends'] = Yii::getAlias('@vendor/yiisoft/yii2-ktgenerator/gii/templates/model/extends');
                    $generator2->template = 'extends';
                    $generator2->generateQuery = true;
                    $generator2->queryNs = $modelNameSpace.'\query';
                    $files2 = $generator2->generate();
                    $answers2 = [];
                    foreach ($files2 as $file2) {
                        $answers2[$file2->id] = 1;
                    }
                    $result2 = '';

                    if ($generator->save($files, $answers, $result)) {
//                        echo '<p>';
//                        echo 'tableName:' . $generator->tableName . ', modelClass:' . $generator->modelClass . '<br />';

                        //check file exist
                        if (!file_exists(Yii::getAlias('@' . str_replace('\\', '/', $generator2->ns)) . '/' . $generator2->modelClass . '.php')) {
                            if ($generator2->save($files2, $answers2, $result2)) {
//                                echo Yii::getAlias('@' . str_replace('\\', '/', $generator2->ns)) . '/' . $generator2->modelClass . '.php<br />';
//                                echo 'tableName:' . $generator2->tableName . ', modelClass:' . $generator2->modelClass . '<br />';
                            }
                        }
//                        echo '</p>';

                        if (!file_exists(Yii::getAlias('@' . str_replace('\\', '/', $generator2->ns)) . '/' . 'search')) {
                            @mkdir(Yii::getAlias('@' . str_replace('\\', '/', $generator2->ns)) . '/' . 'search', 0775, true);
                        }

                        $tables[] = [
                            'name' => $generator->tableName,
                            'master' => $generator->modelClass,
                            'model' => $generator2->modelClass
                        ];
                    } else {
                        break;
                    }
                }
            }
        }


        return $this->render('index', compact('model', 'tables', 'tmp', 'folderName'));
    }

}

<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<p>
    <a href="<?=Yii::$app->homeUrl?>ktgenerator" class="btn btn-default">&lt;&lt; Go Back To KT Generator</a>
</p>
<div class="ModelGenerator-default-index">
    <h1 class="page-header">CRUD Generator</h1>
    
    <div class="panel panel-default">
        <div class="panel-heading">Form</div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'modelPath')->hint('Ex. @app/models/'); ?>
            <?= $form->field($model, 'modelNamespace')->hint('Ex. app\models\\'); ?>
            <?= $form->field($model, 'controllerNamespace')->hint('Ex. app\controllers\\'); ?>
            <?= $form->field($model, 'baseControllerClass')->hint('Ex. yii\web\Controller, common\controllers\MasterController'); ?>
            <?= $form->field($model, 'viewPath')->hint('Ex. @app/views/post, @app/modules/views/post'); ?>
            <?php /*
            <div class="form-group">
                <label class="control-label" for="generator-baseclass">Folder name</label>
                <?= Html::input('text', 'baseControllerClass', $baseControllerClass, ['class'=>'form-control'])?>
                <div class="hint-block">Ex. <?=$baseControllerClass?></div>
                <div class="help-block"></div>
            </div>
            */?>

            <?= \yii\helpers\Html::submitButton('Generate', ['class' => 'btn btn-primary', 'name' => 'preview']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>


    <?php if ($tables !== []): ?>

        <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">

                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Model Class</th>
                        <th>Search Model Class</th>
                        <th>Controller Class</th>
                    </tr>
                    <?php foreach ($tables as $table): ?>
                        <tr>
                            <td><?= $table['modelClass'] ?></td>
                            <td><?= $table['searchModelClass'] ?></td>
                            <td><?= $table['controllerClass'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            </div>
        </div>

    <?php endif; ?>
</div>

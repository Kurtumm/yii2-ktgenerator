<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<p>
    <a href="<?=Yii::$app->homeUrl?>ktgenerator" class="btn btn-default">&lt;&lt; Go Back To KT Generator</a>
</p>
<div class="ModelGenerator-default-index">
    <h1 class="page-header">Extend Model Generator</h1>

    <div class="panel panel-default">
        <div class="panel-heading">Form</div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'db')->hint('db is default value'); ?>
            <?= $form->field($model, 'ns')->hint('Ex. frontend\models')->label('Target Model'); ?>
            <?= $form->field($model, 'baseClass')->hint('Ex. common\models')->label('Base Model'); ?>
            <?//= $form->field($model, 'folderName')->hint('all model files will save in this folder'); ?>
            <div class="form-group">
                <label class="control-label" for="generator-baseclass">Folder name</label>
                <?= Html::input('text', 'folderName', $folderName, ['class'=>'form-control'])?>
                <div class="hint-block">Ex. folderName</div>
                <div class="help-block"></div>
            </div>

            <?= \yii\helpers\Html::submitButton('Generate', ['class' => 'btn btn-primary', 'name' => 'preview']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?php if($tmp):?>
        <div>
            <?php print_r($tmp)?>
        </div>
    <?php endif;?>


    <?php if ($tables !== []): ?>

        <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">

                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Base Model</th>
                        <th>Model</th>
                        <th>Search Model</th>
                    </tr>
                    <?php foreach ($tables as $table): ?>
                        <tr>
                            <td><?= $table['model'] ?></td>
                            <td><?= $table['baseClass'] ?></td>
                            <td><?= $table['targetClass'] ?></td>
                            <td><?= $table['searchModel'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            </div>
        </div>

    <?php endif; ?>
</div>

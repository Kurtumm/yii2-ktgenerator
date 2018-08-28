<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<p>
    <a href="<?=Yii::$app->homeUrl?>ktgenerator" class="btn btn-default">&lt;&lt; Go Back To KT Generator</a>
</p>
<div class="ModelGenerator-default-index">
    <h1 class="page-header">Model Generator</h1>

    <?php $form = ActiveForm::begin(); ?>
    <div class="card card-default">
        <div class="card-header">Form</div>
        <div class="card-body">

            <?= $form->field($model, 'db')->hint('db is default value'); ?>
            <?= $form->field($model, 'ns')->hint('Ex. common\models'); ?>
            <?= $form->field($model, 'baseClass')->hint('Ex. common\models\MasterModel, yii\db\ActiveRecord'); ?>
            <?//= $form->field($model, 'folderName')->hint('all model files will save in this folder'); ?>
            <div class="form-group">
                <label class="control-label" for="generator-baseclass">Folder name</label>
                <?= Html::input('text', 'folderName', $folderName, ['class'=>'form-control'])?>
                <div class="hint-block">Ex. folderName</div>
                <div class="help-block"></div>
            </div>

            <?= $form->field($model, 'enableI18N')->checkbox()->hint('This indicates whether the generator should generate strings using <code>Yii::t()</code> method. Set this to <code>true</code> if you are planning to make your application translatable.'); ?>

        </div>
        <div class="card-footer text-right">
            <?= \yii\helpers\Html::submitButton('Generate', ['class' => 'btn btn-primary', 'name' => 'preview']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <?php if($tmp):?>
        <div>
            <?php print_r($tmp)?>
        </div>
    <?php endif;?>


    <?php if ($tables !== []): ?>

        <div class="card card-default">
            <div class="card-heading"></div>
            <div class="card-body">

                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Table</th>
                        <th>Master Model</th>
                        <th>Model</th>
                    </tr>
                    <?php foreach ($tables as $table): ?>
                        <tr>
                            <td><?= $table['name'] ?></td>
                            <td><?= $table['master'] ?></td>
                            <td><?= $table['model'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            </div>
        </div>

    <?php endif; ?>
</div>

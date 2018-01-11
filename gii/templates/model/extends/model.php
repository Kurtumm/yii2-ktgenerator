<?php
/**
 * This is the template for generating the model class of a specified table.
 */
/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;
<?php
$bc = $generator->modelClass.'Model';
?>
use <?= '\\' . ltrim($generator->baseClass, '\\') ?> as <?=$bc?>;
<?php if ($queryClassName):
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo 'use '.$queryClassFullName.';';
endif; ?>

/**
* This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
*
<?php foreach ($tableSchema->columns as $column): ?>
* @property <?= "{$column->phpType} \${$column->name}\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
*
<?php foreach ($relations as $name => $relation): ?>
* @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
*/

class <?= $className ?> extends <?= $bc."\n"?>
{
    /**
    * @inheritdoc
    */
    public function rules()
    {
        return array_merge(parent::rules(), []);
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), []);
    }

<?php if ($queryClassName): ?>
    /**
    * @inheritdoc
    * @return <?= $queryClassFullName ?> the active query used by this AR class.
    */
    public static function find()
    {
        return new <?= $queryClassName ?>(get_called_class());
    }
<?php endif; ?>
}

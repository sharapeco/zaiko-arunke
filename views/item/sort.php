<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Item;
use kartik\sortinput\SortableInput;

$this->title = Yii::t('app/item', 'Sort items');
?>
<h1><?= Html::encode($this->title) ?></h1>

<?php include __DIR__ . '/_flash.php'; ?>

<div class="form-action">
    <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> '.Yii::t('app/item', 'Back').'', ['/item/index'], ['class'=>'btn btn-default']) ?>
</div>

<?= Html::beginForm(['sort'], 'POST') ?>

<?=
SortableInput::widget([
    'name'=> 'orders',
    'items' => $items,
    'hideInput' => true,
]);
?>

<div class="form-action">
    <?= Html::button('<span class="glyphicon glyphicon-random"></span> ' . Yii::t('app/item', 'Save order'), [
        'type' => 'submit',
        'class' => 'btn btn-primary',
    ]) ?>
</div>

<?= Html::endForm() ?>

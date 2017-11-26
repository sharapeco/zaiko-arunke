<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Item;
use kartik\sortinput\SortableInput;

$this->title = '項目の並べ替え';
?>
<h1><?= Html::encode($this->title) ?></h1>

<?php include __DIR__ . '/_flash.php'; ?>

<div class="form-action">
    <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> '.Yii::t('app', '一覧に戻る').'', ['/item/index'], ['class'=>'btn btn-default']) ?>
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
    <?= Html::button('<span class="glyphicon glyphicon-random"></span> 並べ替えを実行', [
        'type' => 'submit',
        'class' => 'btn btn-primary',
    ]) ?>
</div>

<?= Html::endForm() ?>

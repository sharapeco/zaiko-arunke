<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('app', '項目の変更', [
    'modelClass' => 'Item',
]);
?>

<?php include __DIR__ . '/_flash.php'; ?>

<div class="item-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

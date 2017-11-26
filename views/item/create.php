<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('app', '項目の追加', [
    'modelClass' => 'Item',
]);
?>
<div class="item-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

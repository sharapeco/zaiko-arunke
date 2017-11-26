<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Refill */

$this->title = 'Update Refill: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Refills', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refill-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="text-right">
        <?= Html::a('<span class="glyphicon glyphicon-remove"></span> '.Yii::t('app', '削除').'', ['delete', 'id' => $model->id, 'item_id' => $model->item_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'この項目を削除してもよろしいですか？',
                'method' => 'POST',
            ],
        ]) ?>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Refill */

$this->title = Yii::t('app/refill', 'Refill details');
?>
<div class="refill-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="text-right">
        <?=
        Html::a(
            '<span class="glyphicon glyphicon-remove"></span> ' . Yii::t('app/refill', 'Delete'),
            ['delete', 'id' => $model->id, 'item_id' => $model->item_id],
            [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app/refill', 'Delete this item?'),
                    'method' => 'POST',
                ],
            ])
        ?>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

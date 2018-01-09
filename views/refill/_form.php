<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Refill */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refill-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'refill_time_local')->textInput() ?>

    <div class="form-group">
        <?=
        Html::submitButton(
            Yii::t('app/refill','Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

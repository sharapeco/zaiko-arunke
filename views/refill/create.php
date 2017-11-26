<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Refill */

$this->title = 'Create Refill';
$this->params['breadcrumbs'][] = ['label' => 'Refills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refill-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php
/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use app\models\Item;
use app\models\Refill;

?>
<h1><?= Html::encode($item->name) ?></h1>

<div class="form-action">
    <div class="pull-left">
        <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> '.Yii::t('app/item', 'Back').'', ['/item/index'], ['class'=>'btn btn-default']) ?>
    </div>
    <div class="pull-right">
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> '.Yii::t('app/item', 'Edit').'', ['update', 'id' => $item->id], ['class'=>'btn btn-success']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-remove"></span> '.Yii::t('app/item', 'Delete').'', ['delete', 'id' => $item->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app/item', 'Delete this item?'),
                'method' => 'POST',
            ],
        ]) ?>
    </div>
</div>

<?php include __DIR__ . '/_flash.php'; ?>

<table class="table">
    <tbody>
        <tr>
            <th scope="col"><?= Yii::t('app/item', 'Estimated next refilling date') ?></th>
            <td><?= Html::encode($item->est_refill_time ? Yii::$app->formatter->asDate($item->est_refill_time, Yii::t('app', 'php:j F Y')) : '----'); ?></td>
        </tr>
        <tr>
            <th scope="col"><?= Yii::t('app/item', 'Last refilling date') ?></th>
            <td><?= Html::encode($item->last_refill_time ? Yii::$app->formatter->asDate($item->last_refill_time, Yii::t('app', 'php:j F Y H:i')) : '----'); ?></td>
        </tr>
        <tr>
            <th scope="col"><?= Yii::t('app/item', 'Frequency') ?></th>
            <td><?= Html::encode(($tmp = $item->getFrequency()) ? $tmp : '----'); ?></td>
        </tr>
    </tbody>
</table>

<?php
    $form = ActiveForm::begin([
        'id' => 'createrefillform',
        'action' => Url::to(['refill/create', 'item_id' => $item->id]),
        'options' => [
            'method' => 'POST',
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-9 col-md-4\">{input}</div>\n<div class=\"col-md-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-md-2 col-sm-3 control-label'],
        ],
    ]);
?>
<div class="alert alert-info">

    <?= $form->field($newRefill, 'amount', [
        'addon' => ['append' => ['content' => $item->unit]],
    ])->textInput(['size' => 10, 'type' => 'tel']) ?>

    <?= $form->field($newRefill, 'refill_time_local')->textInput(['size' => 10, 'type' => 'datetime']) ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
        <?= Html::submitButton('<span class="glyphicon glyphicon-plus"></span> '.Yii::t('app/item', 'Refill'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?= GridView::widget([
    'dataProvider' => $refillsDataProvider,
    'tableOptions' => ['class'=>'table table-striped table-hover'],
    'emptyText' => '',
    'summary' =>  '',
    'showFooter' => false,
    'showOnEmpty' => false,
    'rowOptions' => function($refill, $index, $widget, $grid) use ($item) {
            return [
                'id' => $refill['id'],
                'onclick' => 'location.href="'
                    . Url::to(['refill/update', 'id' => $refill['id'], 'item_id' => $item->id])
                    . '";',
                'style' => "cursor: pointer",
            ];
    },
    'columns' => [
        [
            'attribute' => 'refill_time',
            'enableSorting' => false,
            'value' => function ($refill) {
                return $refill->refill_time <> '' ? Yii::$app->formatter->asDate($refill->refill_time, 'php:’y n/j H:i') : '';
            },
            'contentOptions'=>['style'=>'width: 150px; text-align:left'],
        ],
        [
            'attribute' => 'amount',
            'enableSorting' => false,
            'value' => function ($refill) use ($item) {
                return number_format($refill->amount) . ' ' . $item->unit;
            },
            'contentOptions'=>['style'=>'text-align:left'],
        ]
    ],
]);
 ?>

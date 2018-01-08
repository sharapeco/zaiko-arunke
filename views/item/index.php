<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Item;

$this->title = Yii::t('app/item', 'Items');
?>

<?php include __DIR__ . '/_flash.php'; ?>

<?php if ($dataProvider->getCount() === 0): ?>
    <p class="text-danger"><?= Yii::t('app/item', 'No items.') ?></p>
<?php else: ?>
    <?php foreach ($dataProvider->getModels() as $model): ?>
    <a class="item-block item-block-<?= $model->getStatus() ?>" href="<?= Yii::$app->urlManager->createUrl('item/' . $model->id) ?>">
        <div class="item-name"><?= Html::encode($model->name); ?></div>
        <div class="item-est-refill-date">
            <span><?= Yii::t('app/item', 'You’ll refill at') ?></span>
            <strong><?= Html::encode($model->est_refill_time ? Yii::$app->formatter->asDate($model->est_refill_time, 'php:’y n/j') : '----'); ?></strong>
        </div>
        <div class="item-last-refill-date">
            <span><?= Yii::t('app/item', 'Last refilling date') ?></span>
            <strong><?= Html::encode($model->last_refill_time ? Yii::$app->formatter->asDate($model->last_refill_time, 'php:’y n/j') : '----'); ?></strong>
        </div>
    </a>
    <?php endforeach; ?>
<?php endif; ?>

<div class="form-action">
    <?= Html::a('<span class="glyphicon glyphicon-plus"></span> '.Yii::t('app/item', 'Add').'', ['/item/create'], ['class'=>'btn btn-primary']) ?>
    <?= Html::a('<span class="glyphicon glyphicon-random"></span> '.Yii::t('app/item', 'Sort').'', ['/item/sort'], ['class'=>'btn btn-default']) ?>
</div>

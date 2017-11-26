<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Item;

$this->title = '項目';
?>

<?php include __DIR__ . '/_flash.php'; ?>

<?php if ($dataProvider->getCount() === 0): ?>
    <p class="text-danger">在庫を管理する項目を追加してください</p>
<?php else: ?>
    <?php foreach ($dataProvider->getModels() as $model): ?>
    <a class="item-block item-block-<?= $model->getStatus() ?>" href="<?= Yii::$app->urlManager->createUrl('item/' . $model->id) ?>">
        <div class="item-name"><?= Html::encode($model->name); ?></div>
        <div class="item-est-refill-date">
            <span>次回交換目安</span>
            <strong><?= Html::encode($model->est_refill_time ? Yii::$app->formatter->asDate($model->est_refill_time, 'php:’y n/j') : '----'); ?></strong>
        </div>
        <div class="item-last-refill-date">
            <span>前回交換</span>
            <strong><?= Html::encode($model->last_refill_time ? Yii::$app->formatter->asDate($model->last_refill_time, 'php:’y n/j') : '----'); ?></strong>
        </div>
    </a>
    <?php endforeach; ?>
<?php endif; ?>

<div class="form-action">
    <?= Html::a('<span class="glyphicon glyphicon-plus"></span> '.Yii::t('app', '項目の追加').'', ['/item/create'], ['class'=>'btn btn-primary']) ?>
    <?= Html::a('<span class="glyphicon glyphicon-random"></span> '.Yii::t('app', '並べ替え').'', ['/item/sort'], ['class'=>'btn btn-default']) ?>
</div>

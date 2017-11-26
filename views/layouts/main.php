<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/jpeg" href="<?= Yii::$app->homeUrl ?>assets/img/favicon.jpg">
	<link rel="apple-touch-icon" sizes="256x256" href="<?= Yii::$app->homeUrl ?>assets/img/favicon.jpg">
	<?= Html::csrfMetaTags() ?>
	<title>在庫あるんけ</title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
	<?php
	NavBar::begin([
		'brandLabel' => '在庫あるんけ',
		'brandUrl' => Yii::$app->homeUrl,
		'options' => [
			'class' => 'navbar-default navbar-fixed-top',
		],
	]);
	echo Nav::widget([
		'options' => ['class' => 'navbar-nav navbar-right'],
		'items' => Yii::$app->user->isGuest ? ([
			['label' => 'ログイン', 'url' => ['/site/login']],
		]) : ([
			['label' => '在庫あるんけについて', 'url' => ['/site/about']],
			['label' => '項目一覧', 'url' => ['/item/index']],
			//['label' => 'User', 'url' => ['/user']],
			[
				'label' => 'ログアウト (' . Yii::$app->user->displayName . ')',
				'url' => ['/user/logout'],
				'linkOptions' => ['data-method' => 'post'],
			],
		]),
	]);
	NavBar::end();
	?>

	<div class="container">
		<?= Breadcrumbs::widget([
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		]) ?>
		<?= Alert::widget() ?>
		<?= $content ?>
	</div>
</div>

<footer class="footer">
	<div class="container">
		<p class="pull-left">&copy; Shinichiro Yabu <?= date('Y') ?></p>

		<p class="pull-right"><?= Yii::powered() ?></p>
	</div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

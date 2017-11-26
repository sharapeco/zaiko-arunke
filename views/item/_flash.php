<?php foreach (Yii::$app->session->getAllFlashes() as $key=>$message):?>
    <?php $alertClass = substr($key, strpos($key,'-')+1); ?>
    <div class="alert alert-dismissible alert-<?=$alertClass?>" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p><?=$message?></p>
    </div>
<?php endforeach ?>

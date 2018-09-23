<h4>Hello! This is chat. You can to write message!</h4>
<?= \common\modules\chat\widgets\Chat::widget(['port' => 8080]); ?>

<?php \yii\widgets\Pjax::begin(); ?>
<?= \yii\helpers\Html::a('Refresh', ['test/index'], ['class' => 'btn-primary']) ?>
<h1>Сейчас: <?= date('H:i:s') ?></h1>
<?php \yii\widgets\Pjax::end(); ?>
<?php
?>
<?php
use yii\helpers\Html;
/**
 * @var $this \yii\web\View
 * @var $user \common\models\User
 * @var  $project \common\models\Project
 * @var $role string
 */
?>

Hello <?= Html::encode ($user->username) ?>

There are in project <?= $project->title ?> your role will be <?= $role?>

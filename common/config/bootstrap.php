<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
\yii\base\Event::on(
    \yii\db\ActiveQuery::class,
    \yii\db\ActiveRecord::EVENT_AFTER_UPDATE,
    function (\yii\db\AfterSaveEvent $e){
        Yii::info(print_r($e, true), '-');
    }
);

\yii\base\Event::on(
    \common\services\ProjectService::class,
\common\services\ProjectService::EVENT_ASSIGN_ROLE,

                function(\common\services\AssignRoleEvent $e)
                {
                    Yii::info(\common\services\ProjectService::EVENT_ASSIGN_ROLE, '_');
                    $views = ['html' => 'assignRoleToProject-html', 'test' => 'assignRoleToProject-text'];
                    $data = ['user' => $e->user, 'project' => $e->project, 'role' => $e->role];
                    Yii::$app->emailService->send($e->user->email, 'New role' .$e->role, $views, $data);
                }
        );

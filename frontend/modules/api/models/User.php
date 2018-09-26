<?php

namespace frontend\modules\api\models;


class User extends \common\models\User
{
    public function fields()
    {
        return [
            'id',
            'name' => function (User $model) {
return $model ->username. ''. \common\models\User::STATUSES[
    $model->status];
            }

        ];
    }
    public function extraFields()
    {
        return [
            'projectUsers', 'projects'
        ];
    }

}
<?php

namespace common\models\query;


use yii\db\ActiveQuery;
/**
 * This is the ActiveQuery class for [[\common\models\ProjectUser]].
 *This is the ActiveQuery class for [[\common\models\ProjectService]].
 * @see \common\models\ProjectUser
 */
class Project_UserQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function byUser($userId, $role = null){
        $this->andWhere(['user_id' => $userId]);
        if ($role) {
            $this->andWhere(['role' => $role]);
        }
        return $this;
    }
    /**
     * {@inheritdoc}
     * @return \common\models\ProjectUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ProjectUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

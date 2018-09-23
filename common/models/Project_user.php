<?php

namespace common\models;

use Yii;
use common\models\query\Project_UserQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "project_user".
 *
 * @property int $project_id
 * @property int $user_id
 * @property string $role
 *
 * @property Project $project
 * @property User $user
 */
class Project_user extends ActiveRecord
{
    const ROlE_DEVELOPER = 'developer';
    const ROlE_MANAGER = 'manager';
    const ROlE_TESTER = 'tester';
    const ROLES = [
self::ROlE_DEVELOPER =>'разработчик',
   self::ROlE_MANAGER => 'менеджер',
   self::ROlE_TESTER => 'тестировщик'
    ];
    public static function primaryKey()
    {
        return ['project_id', 'user_id', 'role'];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['role'], 'string'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' =>
                Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' =>
                User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'project_id' => 'Project ID',
            'user_id' => 'User ID',
            'role' => 'Role',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\Project_UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new Project_UserQuery(get_called_class());
    }

}

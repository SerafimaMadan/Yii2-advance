<?php

namespace common\models;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

use yii\db\ActiveRecord;
use common\models\ProjectUser;
use common\models\query\Project_UserQuery;



/**
 * This is the model class for table "project".
 *
 *
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property boolean $active
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 * @property User $creator
 * @property User $updater
 * @property ProjectUser $projectUsers
 */
class Project extends ActiveRecord
{
    const RELATION_PROJECT_USERS = 'projectUsers';

    const STATUS_NOTACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_NOTACTIVE => 'неактивен',
        self::STATUS_ACTIVE => 'активен',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'created_by', 'created_at'], 'required'],
            [['description'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'active'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' =>
                User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' =>
                User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }
    public function behaviors()
    {
        return [
           ['class' => TimestampBehavior::class],
            ['class' => BlameableBehavior::class],
            'saveRelations' => [
                'class' => SaveRelationsBehavior::class,
                'relationKeyName' =>
                SaveRelationsBehavior::RELATION_KEY_RELATION_NAME,
                'relations' => [
                    self::RELATION_PROJECT_USERS,
                ]
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'active' => 'Active',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function fields()
    {
        return ['id', 'title'];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return   Project_UserQuery | \yii\db\ActiveQuery
     * @return
     */
    public function getProjectUsers()
    {
        return $this->hasMany(\common\models\ProjectUser::className(), ['project_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks(){
        return $this->hasMany(Task::className(), ['project_id'=>'id']);
    }
    /**
     * {@inheritdoc}
     * @return \common\models\query\ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProjectQuery(get_called_class());
    }


    public function getUsersData(){
        return  $this->getProjectUsers()-> select('role')->indexBy('user_id')->column();
    }

}

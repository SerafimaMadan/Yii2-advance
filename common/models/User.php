<?php

namespace common\models;

use mohorev\file\UploadBehavior;
use mohorev\file\UploadImageBehavior;
use tests\models\ProjectUser;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\validators\UniqueValidator;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property string $avatar
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @mixin UploadImageBehavior
 */
class User extends ActiveRecord implements IdentityInterface
{
    private $_password;
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUSES = [
        self::STATUS_DELETED => 'удалён',
        self::STATUS_ACTIVE => 'активен',
    ];

    const SCENARIO_ADMIN_CREATE = 'admin_create';
    const SCENARIO_ADMIN_UPDATE = 'admin_update';
    const AVATAR_ICO = 'ico';
    const AVATAR_PREVIEW = 'preview';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $host = Yii::$app->params['front.scheme'] . Yii::$app->params['front.domain'];
        return [
            TimestampBehavior::className(),
            [
                'class' => UploadImageBehavior::class,
                'attribute' => 'avatar',
                'scenarios' => [self::SCENARIO_ADMIN_UPDATE, self::SCENARIO_ADMIN_CREATE],
                //'placeholder' => '@frontend/web/upload/user/5.jpg',
                'path' => '@frontend/web/upload/user/{id}',
                'url' => $host . '/upload/user/{id}',

                'thumbs' => [
                    self::AVATAR_PREVIEW => ['width' => 400, 'quality' => 90],
                    self::AVATAR_ICO => ['width' => 30, 'height' => 20],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            [['avatar'], 'file',
                'extensions' => ['jpg', 'gif', 'png'],
                'minSize' => 1000,
                'maxSize' => 1000000],
            [['password'], 'string', 'min' => 4],
            [['password', 'email', 'username'], 'required', 'on' => self::SCENARIO_ADMIN_CREATE],
            [['email', 'username'], 'required', 'on' => self::SCENARIO_ADMIN_UPDATE],

            ['email', 'email', 'on' => [self::SCENARIO_ADMIN_CREATE, self::SCENARIO_ADMIN_UPDATE]],
            ['username', UniqueValidator::class, 'on' => [self::SCENARIO_ADMIN_CREATE, self::SCENARIO_ADMIN_UPDATE]],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($insert) {
            $this->generateAuthKey();
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function getPassword()
    {
        return $this->password = 'password';
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        // \yii\helpers\VarDumper::dump($password, 5, true);
        if (!$password) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }
        $this->password = $password;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function fields()
    {
        return ['id', 'name' => function (User $models) {
            return $models->username . ' ' . User::STATUSES[$models->status];
        }
        ];
    }

    public function extraFields()
    {
        return ['projectUsers', 'projects'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::className(), ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['id' => 'project_id'])->via('projectUsers');
    }
    public function getAvatar()
    {
        return $this->getThumbUploadUrl('avatar', User::AVATAR_ICO);
        // your custom code
    }

    public function getUsername()
    {
        return $this->username.'#'.$this->id;
        // your custom code
    }

}

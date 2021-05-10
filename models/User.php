<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string|null $auth_token
 * @property string|null $date
 * @property int|null $status
 *
 * @property Post[] $posts
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['date'], 'safe'],
            [['status'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
            [['auth_token'], 'string', 'max' => 100],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'username'   => Yii::t('app', 'Username'),
            'password'   => Yii::t('app', 'Password'),
            'auth_token' => Yii::t('app', 'Auth Token'),
            'date'       => Yii::t('app', 'Date'),
            'status'     => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @throws Exception
     */
    public function generateToken(): void
    {
        $this->auth_token = Yii::$app->security->generateRandomString(25);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return ActiveQuery
     */
    public function getPosts(): ActiveQuery
    {
        return $this->hasMany(Post::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]) ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['auth_token' => $token]);
    }


    /**
     * @param $username
     * @return User|null
     */
    public static function findByUsername($username): ?User
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): ?string
    {
        return $this->auth_token;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_token === $authKey;
    }


    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
}

<?php

namespace app\models;

use app\commands\CustomBehaviors;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $text
 * @property int|null $user_id
 * @property string|null $date
 * @property int|null $status
 * @property int|null $update_at
 *
 * @property User $user
 */
class Post extends ActiveRecord
{
    public $captcha;

    /**
     * @return string[][]
     */
    public function behaviors(): array
    {
        return [
            [
                'class'              => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%post}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'status', 'updated_at', 'created_at'], 'integer'],
            [['date'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['text'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            ['captcha', 'captcha']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'title'      => Yii::t('app', 'Title'),
            'text'       => Yii::t('app', 'Text'),
            'user_id'    => Yii::t('app', 'User ID'),
            'date'       => Yii::t('app', 'Date'),
            'status'     => Yii::t('app', 'Status'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $text
 * @property int|null $auth_id
 * @property string|null $date
 * @property int|null $status
 * @property int|null $updated_at
 *
 * @property User $auth
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['auth_id', 'status', 'updated_at'], 'integer'],
            [['date'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['auth_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['auth_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'auth_id' => Yii::t('app', 'Auth ID'),
            'date' => Yii::t('app', 'Date'),
            'status' => Yii::t('app', 'Status'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Auth]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuth()
    {
        return $this->hasOne(User::className(), ['id' => 'auth_id']);
    }
}

<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property int|null $created_at
 * @property AuthItem $itemName
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['created_at'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64],
            [['item_name', 'user_id'], 'unique', 'targetAttribute' => ['item_name', 'user_id']],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['item_name' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'item_name'  => Yii::t('app', 'Item Name'),
            'user_id'    => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[ItemName]].
     *
     * @return ActiveQuery
     */
    public function getItemName(): ActiveQuery
    {
        return $this->hasOne(AuthItem::class, ['name' => 'item_name']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return array
     */
    public static function getItemsList(): array
    {
        $list = AuthItem::find()
            ->asArray()
            ->all();
        return ArrayHelper::map($list, 'name', function($model){
            return $model['name'].' '.AuthItem::typeList()[$model['type']];
        });
    }

    /**
     * @return array
     */
    public static function getUsersList(): array
    {
        $users = User::find()
            ->asArray()
            ->all();
        return ArrayHelper::map($users, 'id', 'username');
    }
}

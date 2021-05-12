<?php
namespace app\modules\admin\rules;

use app\models\AuthAssignment;
use yii\rbac\Item;
use yii\rbac\Rule;

class UpdateAdminRule extends Rule
{
    public string $name = 'isUpdateRule';

    /**
     * @param int $user user_id
     * @param Item $item
     * @param array $params
     * @return bool
     */
    public function execute($user, $item, $params): bool
    {
        $user_id = $user;
        return AuthAssignment::findOne(['user_id' => $user_id, 'item_name' => $item->name])? true : false;
    }
}
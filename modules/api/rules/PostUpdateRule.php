<?php

namespace app\modules\api\rules;

use yii\rbac\Item;
use yii\rbac\Rule;

class PostUpdateRule extends Rule
{
    public string $name = 'isPostUpdate';

    /**
     * @param int $user user_id
     * @param Item $item
     * @param array $params
     * @return bool
     */
    public function execute($user, $item, $params): bool
    {
        $user_id = $user;
        if (!empty($params)) {
            $data = $params['post'];
            return $user_id === $data->user_id;
        } else {
            return false;
        }
    }
}
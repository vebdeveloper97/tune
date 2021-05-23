<?php


namespace app\modules\news\rules;


use yii\rbac\Item;
use yii\rbac\Rule;

class isUpdateNews extends Rule
{
    public string $name = 'isUpdateNews';

    private static array $actionList = [
        'update',
        'view'
    ];

    /**
     * @param int|string $user
     * @param Item $item
     * @param array $params
     * @return bool
     */
    public function execute($user, $item, $params): bool
    {
        $allow = false;
        if (!empty($params)) {
            foreach ($params as $key => $param) {
                if (in_array($param, self::$actionList)) {
                    return true;
                }
            }
        }

        return false;
    }
}
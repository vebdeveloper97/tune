<?php


namespace app\models\forms;


use app\models\AuthItem;
use app\models\model\BaseModel;
use Yii;
use yii\base\BaseObject;

class AuthItemForm extends BaseModel
{
    /**
     * @param AuthItem $model
     * @return bool
     * @throws \Exception
     */
    public function saveItem(AuthItem $model): bool
    {
        $auth = Yii::$app->authManager;

        if ($model->type == $model::TYPE_PERMISSION && !empty($model->rule_name)) {
            $rule = new $model->rule_name;
            $auth->add($rule);
            $permission = $auth->createPermission($model->name);
            $permission->description = $model->description;
            $permission->ruleName = $rule->name;
            $auth->add($permission);
            Yii::$app->session->setFlash('info', Yii::t('app', 'Success save.'));
            return true;
        }

        if (!$model->validate()) {
            $this->getErrorsSession($model);
            return false;
        }

        $role = $auth->createRole($model->name);
        $role->description = $model->description;
        $role->ruleName = ($model->rule_name != '') ? $model->rule_name : null;
        $auth->add($role);
        Yii::$app->session->setFlash('info', Yii::t('app', 'Success save.'));
        return true;
    }
}
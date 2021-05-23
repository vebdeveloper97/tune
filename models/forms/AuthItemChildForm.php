<?php


namespace app\models\forms;


use app\models\AuthItem;
use app\models\AuthItemChild;
use app\models\model\BaseModel;
use Yii;
use yii\base\Exception;

class AuthItemChildForm extends BaseModel
{

    /**
     * @param AuthItemChild $model
     * @return bool
     */
    public function saveChild(AuthItemChild $model): bool
    {
        $auth = Yii::$app->authManager;
        if (!$model->validate()) {
            $this->getErrorsSession($model);
            return false;
        }
        $role1 = $auth->getRole($model->parent);
        $role1 = $role1 ?? $auth->getPermission($model->parent);
        $role2 = $auth->getRole($model->child);
        $role2 = $role2 ?? $auth->getPermission($model->child);
        $auth->addChild($role1, $role2);
        Yii::$app->session->setFlash('info', Yii::t('app', 'Success save.'));
        return true;
    }
}
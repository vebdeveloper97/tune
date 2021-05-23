<?php


namespace app\models\forms;


use app\models\AuthAssignment;
use app\models\model\BaseModel;
use Yii;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;

class AuthAssignmentForm extends BaseModel
{
    /**
     * @param AuthAssignment $model
     * @return bool
     * @throws \Exception
     */
    public function saveAssignment(AuthAssignment $model): bool
    {
        if (!$model->validate()) {
            $this->getErrorsSession($model);
            return false;
        }
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($model->item_name);
        $role = $role ?? $auth->getPermission($model->item_name);
        if ($role === null) {
            $this->getErrorsSession($model, "{$model->item_name} nomli ruxsat mavjud emas!");
            return false;
        }
        $auth->assign($role, $model->user_id);
        Yii::$app->session->setFlash('info', Yii::t('app', 'Success save.'));
        return true;
    }
}
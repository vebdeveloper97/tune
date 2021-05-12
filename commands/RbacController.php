<?php


namespace app\commands;


use app\models\User;
use app\modules\admin\rules\UpdateAdminRule;
use app\modules\api\rules\PostUpdateRule;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;

class RbacController extends Controller
{
    /**
     * @param string $name
     * @param string $description
     * @return int
     * @throws \Exception
     */
    public function actionCreateRole(string $name, string $description): int
    {
        $auth = Yii::$app->authManager;

        if ($auth->getRole($name) !== null) {
            echo "{$name} role already exists!\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $role = $auth->createRole($name);
        $role->description = $description;
        $auth->add($role);

        echo "{$name} role created!\n";
        return ExitCode::OK;
    }


    /**
     * @param int $user_id
     * @param string $role_name
     * @return int
     * @throws \Exception
     */
    public function actionAssignRole(int $user_id, string $role_name): int
    {
        if (($user = User::findOne(['id' => $user_id])) === null) {
            echo "{$user_id} not found!\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $auth = Yii::$app->authManager;

        if (($role = $auth->getRole($role_name)) === null) {
            echo "{$role_name} not found!\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $roles = ArrayHelper::getColumn($auth->getRolesByUser($user_id), 'name');

        if (in_array($role_name, $roles, true)) {
            echo "{$role_name} already created for user {$user->id}\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $auth->assign($role, $user->id);
        echo "{$role_name} add assign for user {$user->id}\n";
        return ExitCode::OK;
    }

    public function actionCreatePermission(string $permission_name, string $description)
    {
        $auth = Yii::$app->authManager;
//        $rule = new PostUpdateRule();
        $rule = new UpdateAdminRule();
        $auth->add($rule);

        $updateOwnPost = $auth->createPermission($permission_name);
        $updateOwnPost->description = $description;
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);
    }


    /**
     * @param int $user_id
     * @param string $permission_name
     * @return int
     * @throws \Exception
     */
    public function actionAssignPermission(int $user_id, string $permission_name): int
    {
        $auth = Yii::$app->authManager;
        if (($permission = $auth->getPermission($permission_name)) === null) {
            echo "{$permission_name} not found!\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }
        $roles = ArrayHelper::getColumn($auth->getPermissionsByUser($user_id), 'name');

        if (in_array($permission_name, $roles, true)) {
            echo "{$permission_name} already exists!\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $auth->assign($permission, $user_id);
        echo "{$permission_name} created!\n";
        return ExitCode::OK;
    }

}
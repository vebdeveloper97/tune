<?php


namespace app\commands;


use app\models\User;
use Yii;
use yii\base\Exception;
use yii\console\Controller;
use yii\console\ExitCode;

class UserAddController extends Controller
{
    /**
     * @param string $username
     * @param string $password
     * @return int
     * @throws Exception
     */
    public function actionAdd(string $username, string $password): int
    {
        if (null !== ($user = User::findOne(['username' => $username]))) {
            echo "user {$username} already exsist!\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $model = new User();
        $model->username = $username;
        $model->password = Yii::$app->security->generatePasswordHash($password);
        $model->date = date('Y-m-d');

        if (!$model->save()) {
            echo "User {$username} not add!\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }

        echo "User {$username} add!\n";
        return ExitCode::OK;
    }
}
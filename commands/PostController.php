<?php


namespace app\commands;


use app\models\Post;
use app\models\User;
use Faker\Factory;
use yii\console\Controller;
use yii\console\ExitCode;

class PostController extends Controller
{
    /**
     * @param int $user_id
     * @param int $count
     * @return int
     */
    public function actionAdd(int $user_id, int $count): int
    {
        if (($user = User::findOne($user_id)) === null) {
            echo "user not found!\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $faker = Factory::create();
        $allow = false;

        for ($i = 0; $i < $count; $i++) {
            $model = new Post();
            $model->title = $faker->realText(20);
            $model->text = $faker->realText(100);
            $model->user_id = $user->id;
            $model->date = date('Y-m-d');
            $model->status = 1;

            if ($model->save()) {
                $allow = true;
            }

            if (!$allow) {
                break;
            }
        }

        if (!$allow) {
            echo "Post data not saved!\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }

        echo "Post data saved!\n";
        return ExitCode::OK;
    }
}
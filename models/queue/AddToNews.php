<?php


namespace app\models\queue;


use app\models\Post;
use Faker\Factory;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class AddToNews extends BaseObject implements JobInterface
{
    public function execute($queue)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $model = new Post();
            $model->title = $faker->title;
            $model->text = $faker->text;
            $model->date = date('Y-m-d');
            $model->status = 1;
            $model->save();
            unset($model);
        }
    }
}
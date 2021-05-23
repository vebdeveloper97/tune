<?php

namespace app\modules\queue\controllers;

use app\commands\DownloadJob;
use app\models\queue\AddToNews;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `queue` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $id = Yii::$app->queue->delay(10)->push(new AddToNews());
        if ($id) {
            return $this->render('index', ['id' => $id]);
        } else {
            return $this->render('index', ['id' => 'Xatolik mavjud!']);
        }
    }

    public function actionTest()
    {

    }
}

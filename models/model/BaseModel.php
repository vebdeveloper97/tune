<?php


namespace app\models\model;


use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;

class BaseModel extends Model
{
    public function getErrorsSession($model, $message = null)
    {
        $error = array_values($model->firstErrors)[0] ?? Yii::t('app', 'Error validate.');
        Yii::$app->session->setFlash('error', Yii::t('app', $message ?? $error));
    }

    /**
     * @param $date
     * @param bool $time
     * @return string
     * @throws InvalidConfigException
     */
    public static function dateFormat($date, $time = false): string
    {
        $formatter = Yii::$app->formatter;
        $formatter->locale = Yii::$app->language;

        if ($time) {
            $date = date_create($date);
            return $formatter->asDate($date) . ' ' . $date->format('H:i:s');
        }
        return $formatter->asDate($date);
    }
}
<?php


namespace app\modules\api\controllers;


use Yii;
use yii\rest\Controller;

class BaseController extends Controller
{
    /**
     * @param array $data
     * @param false $success
     * @param string $error_message
     * @param int $error_code
     * @return array
     */
    public function output($data = [], $success = true, $error_message = '', $error_code = 401): array
    {
        if (!$success) {
            Yii::$app->response->statusCode = $error_code;
            return [
                'code'    => $error_code,
                'message' => $error_message
            ];
        }
        return $data;
    }

}
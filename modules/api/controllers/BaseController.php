<?php


namespace app\modules\api\controllers;


use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

class BaseController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        $parent = parent::behaviors();

        $parent['auth'] = [
            'class'       => CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class,
            ],
        ];

        return $parent;
    }

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
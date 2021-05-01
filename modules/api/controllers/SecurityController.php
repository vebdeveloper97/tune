<?php


namespace app\modules\api\controllers;


use app\modules\api\forms\SecurityForm;
use app\modules\api\resources\UserResource;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;

class SecurityController extends BaseController
{
    public string $modelClass = UserResource::class;

    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['verb'] = [
            'class'   => VerbFilter::class,
            'actions' => [
                'login'          => ['POST'],
                'reset-password' => ['POST']
            ],
        ];

        return $behaviors;
    }

    /**
     * @return array|string|null
     * @throws Exception
     */
    public function actionLogin()
    {
        $model = new SecurityForm();
        $model->scenario = SecurityForm::SCENARIO_LOGIN;
        $params = Yii::$app->request->bodyParams;

        if ($model->load($params) && $model->login()) {
            return $this->output(['auth_token' => $model->auth_token]);
        } else {
            return $this->output([], false, $model->getErrorMessage($model->firstErrors), 500);
        }
    }
}
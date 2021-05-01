<?php


namespace app\modules\api\controllers;


use app\modules\api\filters\PostSearchFilters;
use app\modules\api\resources\PostResource;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\rest\Serializer;

class PostController extends BaseController
{
    /**
     * @var string[]
     */
    public $serializer = [
        'class' => Serializer::class
    ];

    public string $modelClass = PostResource::class;

    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['verb'] = [
            'class'   => VerbFilter::class,
            'actions' => [
                'list' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    /**
     * @return ActiveDataProvider
     */
    public function actionList(): ActiveDataProvider
    {
        $this->serializer['collectionEnvelope'] = 'list';
        $searchModel = new PostSearchFilters();
        $params = Yii::$app->request->bodyParams;
        $perPage = Yii::$app->request->get('perPage', 20);

        if ($perPage > 20 || $perPage < 0) {
            $perPage = 20;
        }
        return $searchModel->search($params, $perPage);
    }
}
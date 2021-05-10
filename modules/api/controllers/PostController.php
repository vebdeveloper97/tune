<?php


namespace app\modules\api\controllers;


use app\modules\api\filters\PostSearchFilters;
use app\modules\api\forms\PostForm;
use app\modules\api\resources\PostResource;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
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
        $parent = parent::behaviors();
        $parent['verbs'] = [
            'class'   => VerbFilter::class,
            'actions' => [
                'list'   => ['POST'],
                'update' => ['POST'],
                'view' => ['GET']
            ],
        ];

        $parent['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'actions'    => ['update', 'view'],
                    'allow'      => true,
                    'roles'      => ['updatePost'],
                    'roleParams' => static function () {
                        return ['post' => PostResource::findOne(['id' => Yii::$app->request->get('id')])];
                    }
                ],
                [
                    'actions' => ['list'],
                    'allow'   => true,
                    'roles'   => ['@']
                ],
            ]
        ];
        return $parent;
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

    /**
     * @return array
     */
    public function actionUpdate(): array
    {
        $id = Yii::$app->request->get('id');
        $params = Yii::$app->request->bodyParams;
        $model = new PostForm();
        return $model->update($params, $id);
    }

    public function actionView()
    {
        $id = Yii::$app->request->get('id');
        $model = PostResource::findOne(['id' => $id]);
        return $this->output(['list' => $model]);
    }
}
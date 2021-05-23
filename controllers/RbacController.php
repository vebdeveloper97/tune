<?php


namespace app\controllers;

use app\exceptions\ResponseException;
use app\models\AuthAssignment;
use app\models\AuthAssignmentSearch;
use app\models\AuthItem;
use app\models\AuthItemChild;
use app\models\AuthItemChildSearch;
use app\models\AuthItemSearch;
use app\models\AuthRule;
use app\models\AuthRuleSearch;
use app\models\forms\AuthAssignmentForm;
use app\models\forms\AuthItemChildForm;
use app\models\forms\AuthItemForm;
use app\models\forms\AuthRoleForm;
use app\models\SlugRbac;
use Yii;
use yii\base\Action;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

class RbacController extends Controller
{
    private ?string $slug = null;

    public function behaviors(): array
    {
        $parent = parent::behaviors();
        $parent['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['admin']
                ]
            ]
        ];

        return $parent;
    }

    /**
     * @param Action $action
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        $slug = Yii::$app->request->get('slug');
        if ($slug !== null) {
            $this->slug = $slug;
        }
        return parent::beforeAction($action);
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $authItemSearch = new AuthItemSearch();
        $authItem = $authItemSearch->search(Yii::$app->request->queryParams);

        $authRuleSearch = new AuthRuleSearch();
        $authRule = $authRuleSearch->search(Yii::$app->request->queryParams);

        $authItemChildSearch = new AuthItemChildSearch();
        $authItemChild = $authItemChildSearch->search(Yii::$app->request->queryParams);

        $authAssignmentSearch = new AuthAssignmentSearch();
        $authAssignment = $authAssignmentSearch->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'authItem'             => $authItem,
            'authRule'             => $authRule,
            'authItemChild'        => $authItemChild,
            'authAssignment'       => $authAssignment,
            'authItemSearch'       => $authItemSearch,
            'authAssignmentSearch' => $authAssignmentSearch,
            'authItemChildSearch'  => $authItemChildSearch,
            'authRuleSearch'       => $authRuleSearch
        ]);
    }

    /**
     * @return string
     * @throws Exception
     * @throws \Exception
     */
    public function actionCreate(): string
    {
        $params = Yii::$app->request->post();

        if ($this->slug !== null) {
            switch ($this->slug) {

                case SlugRbac::AUTH_ITEM:
                    $model = new AuthItem();
                    $form = new AuthItemForm();
                    if ($model->load($params) && $form->saveItem($model)) {
                        $this->redirect(["/rbac/{$this->slug}/index"]);
                    }
                    return $this->render('auth_item/create', [
                        'model' => $model
                    ]);

                case SlugRbac::AUTH_ASSIGNMENT:
                    $model = new AuthAssignment();
                    $form = new AuthAssignmentForm();
                    if ($model->load($params) && $form->saveAssignment($model)) {
                        $this->redirect(["/rbac/{$this->slug}/index"]);
                    }
                    return $this->render('auth_assignment/create', [
                        'model' => $model
                    ]);

                case SlugRbac::AUTH_ITEM_CHILD:
                    $model = new AuthItemChild();
                    $form = new AuthItemChildForm();
                    if ($model->load($params) && $form->saveChild($model)) {
                        $this->redirect(["/rbac/{$this->slug}/index"]);
                    }
                    return $this->render('auth_item_child/create', [
                        'model' => $model
                    ]);

                case SlugRbac::AUTH_RULE:
                    $model = new AuthRule();
                    $form = new AuthRoleForm();
                    return $this->render('auth_rule/create', [
                        'model' => $model
                    ]);

                default:
                    throw new Exception(Yii::t('app', 'Error slug'));
            }
        } else {
            throw new Exception(Yii::t('app', 'Slug not found!'));
        }
    }

    public function actionUpdate()
    {

    }

    /**
     * @return array
     */
    public function actionAuthItemChild(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $name = Yii::$app->request->post('item_name');
        return AuthItem::find()
            ->where(['!=', 'name', $name])
            ->asArray()
            ->all();
    }
}
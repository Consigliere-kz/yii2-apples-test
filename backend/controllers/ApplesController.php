<?php

namespace backend\controllers;

use backend\services\ApplesService;
use common\exceptions\InvalidAppleActionException;
use common\helpers\ApplesFactory;
use common\models\Apple;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\di\Container;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ApplesController implements the CRUD actions for Apple model.
 */
class ApplesController extends Controller
{
    /**
     * @var ApplesService
     */
    private $service;

    /**
     * ApplesController constructor.
     * @param string $id
     * @param Module $module
     * @param array $config
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function __construct(string $id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = (new Container())->get(ApplesService::class);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Apple models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query'      => Apple::find()->where(['>', 'integrity', 0]),
            'pagination' => false,
            'sort'       => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function actionRegenerate()
    {
        /**
         * @var ApplesFactory $factory
         */
        $factory = (new Container())->get(ApplesFactory::class);
        $count   = rand(5, 15);

        Apple::deleteAll();

        for ($i = 0; $i <= $count; $i++) {
            $apple = $factory->random();
            $apple->save();
        }

        return $this->redirect('index');
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionHit($id)
    {
        $apple = $this->findModel($id);

        try {
            $this->service->hit($apple);
        } catch (InvalidAppleActionException $exception) {
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect('index');
    }

    /**
     * @param $id
     * @param $percentage
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionBite($id, $percentage)
    {
        $apple = $this->findModel($id);

        try {
            $this->service->bite($apple, (int)$percentage);
        } catch (InvalidAppleActionException $exception) {
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect('index');
    }

    /**
     * Finds the Apple model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apple the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apple::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

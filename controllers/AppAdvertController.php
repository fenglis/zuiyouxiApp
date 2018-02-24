<?php

namespace app\controllers;

use Yii;
use app\models\AppAdvert;
use app\models\AppAdvertSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Project;
use yii\web\UploadedFile;

/**
 * AppAdvertController implements the CRUD actions for AppAdvert model.
 */
class AppAdvertController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AppAdvert models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppAdvertSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AppAdvert model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AppAdvert model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AppAdvert();
        $project = new Project();
        $projects = $project->getAllProject();

        if ($model->load(Yii::$app->request->post())) {
            $model->created = time();
            $model->img = UploadedFile::getInstance($model,'img');
            if($model->mySave()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'projects' => $projects,
            ]);
        }
    }

    /**
     * Updates an existing AppAdvert model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $project = new Project();
        $projects = $project->getAllProject();

        if ($model->load(Yii::$app->request->post())) {
            $model->img = UploadedFile::getInstance($model,'img');
            if($model->mySave()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'projects' => $projects,
            ]);
        }
    }

    /**
     * Deletes an existing AppAdvert model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AppAdvert model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppAdvert the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AppAdvert::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace app\controllers;

use Yii;
use app\models\AppVersion;
use app\models\AppVersionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Project;
use yii\log\Logger;

/**
 * AppVersionController implements the CRUD actions for AppVersion model.
 */
class AppVersionController extends Controller
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
     * Lists all AppVersion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppVersionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AppVersion model.
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
     * Creates a new AppVersion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AppVersion();
        $project = new Project();
        $projects = $project->getAllProject();

        if ($model->load(Yii::$app->request->post())) {
            $model->created = time();
            $version = $model->getMaxVersionByProject($model->os);
            if(empty($version)) {
                if($model->save()) {
                    return $this->redirect(['index']);
                }
            }
            $ret = $this->versionCompare($model->version, $version);
            if($ret == 0){
                $result = [
                    'model' => $model,
                    'projects' => $projects,
                    'msg' => $model->version . ' 版本已经存在'
                ];
            } elseif ($ret == -1) {
                $result = [
                    'model' => $model,
                    'projects' => $projects,
                    'msg' => $model->version . ' 版本号输入太低'
                ];
            } else {
                if($model->save()) {
                    return $this->redirect(['index']);
                }
            }

            return $this->render('create', $result);

        } else {
            return $this->render('create', [
                'model' => $model,
                'projects' => $projects,
            ]);
        }
    }

    /**
     * Updates an existing AppVersion model.
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
            if($model->save()) {
                return $this->redirect(['index']);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
                'projects'=> $projects,
            ]);
        }
    }

    /**
     * Deletes an existing AppVersion model.
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
     * Finds the AppVersion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppVersion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AppVersion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function versionCompare($versionA,$versionB) {
        $dm = '.';
        $verListA = explode($dm, (string)$versionA);
        $verListB = explode($dm, (string)$versionB);

        $len = max(count($verListA),count($verListB));
        $i = -1;
        while ($i++<$len) {
            $verListA[$i] = intval(@$verListA[$i]);
            if ($verListA[$i] <0 ) {
                $verListA[$i] = 0;
            }
            $verListB[$i] = intval(@$verListB[$i]);
            if ($verListB[$i] <0 ) {
                $verListB[$i] = 0;
            }

            if ($verListA[$i]>$verListB[$i]) {
                return 1;
            } else if ($verListA[$i]<$verListB[$i]) {
                return -1;
            } else if ($i==($len-1)) {
                return 0;
            }
        }

    }
}

<?php

namespace app\controllers;

use app\models\PollOption;
use Yii;
use app\models\Poll;
use app\models\PollSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * VoteThemeController implements the CRUD actions for VoteTheme model.
 */
class PollController extends Controller
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
     * Lists all VoteTheme models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PollSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VoteTheme model.
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
     * Creates a new VoteTheme model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Poll();

        $optionArr = Yii::$app->request->post('voteoption',[]);
        if ($model->load(Yii::$app->request->post())) {
            $model->img = UploadedFile::getInstance($model, 'img');
            $model->created = time();
            $tr = Yii::$app->db->beginTransaction();

            if($model->Mysave()) {
                foreach ($optionArr as $key => $value) {
                    $option = new PollOption();     //开启事务每一次都要new一次新的对象,否则只会插入一条数据
                    if(!empty($value)) {
                        $option->pollid = $model->attributes['pollid'];  //获取vote插入的id
                        $option->content = $value;
                        if(!$option->save()) {
                            $tr->rollBack();
                        }
                    }else {
                    }
                }
                $tr->commit();
                return $this->redirect(['index']);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VoteTheme model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $opArr = [];
        $model = $this->findModel($id);
        $option = new PollOption();
        $opObj = $option->getPollOptionByPollid($model->pollid);

        foreach ($opObj as $op) {
            $opArr[$op->id . ' | ' . $op->content] = $op->votes;
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->img = UploadedFile::getInstance($model, 'img');
            if($model->mySave()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'opArr' => $opArr,
            ]);
        }
    }

    /**
     * Deletes an existing VoteTheme model.
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
     * Finds the VoteTheme model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VoteTheme the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Poll::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

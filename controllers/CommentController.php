<?php

namespace app\controllers;

use Yii;
use app\models\Comment;
use app\models\CommentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ArticleClass;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
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
                    //'delall' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Comment models.
     * @return mixed
     */
    public function actionIndex()
    {

            //var_dump(Yii::$app->request->queryParams); die;

        $searchModel = new CommentSearch();
        $class = new ArticleClass();
        $classTree = $class->getTree();

        $recvData = Yii::$app->request->queryParams;

        //var_dump($classTree); die;
        $dataProvider = $searchModel->search($recvData);
        $dataProvider->setSort(false);  //禁止排序
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'classTree' => $classTree,
        ]);
    }

//    /**
//     * Displays a single Comment model.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }
//
//    /**
//     * Creates a new Comment model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     * @return mixed
//     */
    public function actionCreate()
    {
        $model = new Comment();
       //var_dump(Yii::$app->request->post()); die;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
//
//    /**
//     * Updates an existing Comment model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Deletes an existing Comment model.
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
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDelall($ids)
    {
        $model =new Comment();
        \yii::getLogger()->log("get all id {$ids}", LOG_DEBUG);

        if($model->deleteAll("id in($ids)")){
            Yii::$app->getSession()->setFlash('error', '批量删除成功');

        }else{
            Yii::$app->getSession()->setFlash('error', '批量删除失败');
        }
        $this->redirect(['index']);
    }
}

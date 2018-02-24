<?php

namespace app\controllers;

use Yii;
use app\models\BattleRecommend;
use app\models\BattleRecommendSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BattleRecommendController implements the CRUD actions for BattleRecommend model.
 */
class BattleRecommendController extends Controller
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
     * Lists all BattleRecommend models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BattleRecommendSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BattleRecommend model.
     * @param integer $id
     * @return mixed
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new BattleRecommend model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BattleRecommend();

        if ($model->load(Yii::$app->request->post())) {

            $model->created = time();
            $path = Yii::$app->params['attachPath'].Yii::$app->params['recommendImage'].'/';
            //武将
            $heroArr = $this->uploadImgs($_FILES['generals'], $path);
            if(count($heroArr) < 6) {
                $msg = '武将上传少于6人';
                return $this->render('create', ['model' => $model, 'msg' => $msg]);
            }
            $model->generals = implode(",", $heroArr);
            //游戏截图
            $shotArr = $this->uploadImgs($_FILES['screenshot'], $path);
            $model->screenshot = implode(",", $shotArr);

            //添加数据库
            if($model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing BattleRecommend model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $msg = '';
        if ($model->load(Yii::$app->request->post())) {
            $path = Yii::$app->params['attachPath'].Yii::$app->params['recommendImage'].'/';
            //武将
            $heroArr = $this->uploadImgs($_FILES['generals'], $path);
            $model->generals = implode(",", $heroArr);
            //游戏截图
            $shotArr = $this->uploadImgs($_FILES['screenshot'], $path);
            $model->screenshot = implode(",", $shotArr);

            //添加数据库
            if($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
                'model' => $model,
                'msg' => $msg,
            ]);
    }

    /**
     * Deletes an existing BattleRecommend model.
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
     * Finds the BattleRecommend model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BattleRecommend the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BattleRecommend::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    function uploadImgs($upload,$uploadPathPhysical,$dirname=''){
        //$upload=$_FILES["upfile"];
        $newfilename='';
        if(empty($upload)){
            return array();
        }

        \Yii::error("upload: %s", $upload);
        $arrImgFiles = array();
        foreach($upload['name'] as $_key=>$_value){
            $filename=$_value;
            $k=strrpos($filename,".");
            $ext=substr($filename,$k+1);
            $key = $this->getRandomString(4);
            $newfilename=$key.time().".".$ext;
            $mDir = date('Ym').'/';
            if (!file_exists($uploadPathPhysical)){
                mkdir($uploadPathPhysical, 0755);
            }

            if($dirname!=''){
                if (!file_exists($uploadPathPhysical.$dirname)){
                    mkdir($uploadPathPhysical.$dirname, 0755);
                }
                if (!file_exists($uploadPathPhysical.$dirname.'/'.$mDir)){
                    mkdir($uploadPathPhysical.$dirname.'/'.$mDir, 0755);
                }
                $newUpDir = $uploadPathPhysical.$dirname.'/'.$mDir;
                $per = $dirname.'/'.$mDir;
            }else{
                if (!file_exists($uploadPathPhysical.$mDir)){
                    mkdir($uploadPathPhysical.$mDir, 0755);
                }
                $newUpDir = $uploadPathPhysical.$mDir;
                $per = $mDir;
            }

            if(move_uploaded_file($upload['tmp_name'][$_key],$newUpDir.$newfilename)){
                $arrImgFiles[] = "{$mDir}"."{$newfilename}";
                \Yii::error("1:%s, 2:%s", $upload['tmp_name'][$_key], $newUpDir.$newfilename);
            }
        }
        return $arrImgFiles;
    }

    function getRandomString($length) {

        $template = "1234567890abcdefghijklmnopqrstuvwxyz_";
        settype($template, "string");
        settype($length, "integer");
        settype($randStr, "string");
        settype($a, "integer");
        settype($b, "integer");
        for ($a = 0; $a < $length; $a++) {
            $b = rand(0, strlen($template) - 1);
            $randStr .= $template[$b];
        }
        return $randStr;

    }
}

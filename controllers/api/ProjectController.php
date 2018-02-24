<?php

namespace app\controllers\api;

use app\components\ErrorCode;
use app\components\Util;
use app\models\api\AppAdvert;
use app\models\api\Project;
use app\models\AppVersion;


class ProjectController extends \yii\web\Controller
{
    /**
     * 获取所有游戏接口
     */
    public function actionGetprojectlist()
    {
        $response = [];
        $model = new Project();
        $data = $model->getProjectList();

        $response['content'] = $data;
        $response['errid'] = ErrorCode::OK;
        $response['errmsg'] = ErrorCode::$msgArr[ErrorCode::OK];
        Util::responseJson();
        return $response;
    }


    public function actionGetadvert()
    {
        Util::responseJson();
        try {
            $arrRequest = Util::getArrRequest();
            $project_id =  Util::getParameter ( $arrRequest, 'siteId', 'int',true );   //项目id
        } catch (Exception $e) {
            Yii::warning($e->getMessage());
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }
        $result = AppAdvert::getAdvert($project_id);
        if(empty($result)) {
            return [
                'error' => 1
            ];
        }
        $result['img'] = \Yii::$app->params['attachUrl'] . \Yii::$app->params['advertImage'] . '/' . $result['img'];

        return $result;
    }

    public function actionGetversion()
    {
        Util::responseJson();
        try {
            $arrRequest = Util::getArrRequest();
            $device =  Util::getParameter ( $arrRequest, 'device', 'int',true );
            $version = Util::getParameter ( $arrRequest, 'version', 'string',true );
        } catch (Exception $e) {
            Yii::warning($e->getMessage());
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }

        $result = self::getVersion($device,$version);

        return $result;
    }

    public static function getVersion($device,$version)
    {
        $ret = [
            'errid'=> ErrorCode::OK,
            'errmsg'=> "ok",
            'isShow'=>1
        ];

        $info = \app\models\api\AppVersion::getVersion($device);
        if(!empty($info)) {
            if($device == 1) { //ios
                if(version_compare($version,$info['version']) == 1){
                    $ret['isShow'] = 0;
                }
            }
            if($device == 2) { //android
                $ret['version'] = $info['version'];
                $ret['url'] = $info['url'];
                $ret['title'] = $info['title'];
                $ret['content'] = $info['content'];
            }
            return $ret;
        } else {
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }
    }
}

<?php

namespace app\hook;
use PHPUnit\Framework\Exception;

/**
 * action执行之前url和sign的检测
 * Class CheckUrlSignBefore
 */
class CheckUrlSignBefore {


    public static function execute () {
        $arrRequest = [];
        if(!strstr($_SERVER['REQUEST_URI'], 'api')) {
            return true;
        }

        if(\Yii::$app->request->isPost){
            $arrRequest = \Yii::$app->request->post();
        } elseif(\Yii::$app->request->isGet) {
            $arrRequest = \Yii::$app->request->get();
        } else {
            \Yii::warning('not support request method');
            throw new Exception('not support request method');
        }

        try {
            //self::urlivalidity($arrRequest);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        return true;
    }

    public static function urlivalidity($arrRequest) {
        if(in_array ( strstr($_SERVER [ 'REQUEST_URI' ],'?',true), \Yii::$app->params['noCheckUrlSignApi'] )){
            return true;
        }
        //检测api时间
        $nowTime = time();
        if(!isset($arrRequest['t']) || abs($arrRequest['t']-$nowTime)>\Yii::$app->params['apiTimeOut']){
            $timeOut = isset($arrRequest['t'])?$arrRequest['t']:0;
            \Yii::error( "API request is timeout system: {$nowTime} user: {$timeOut}");
            throw new \Exception ( 'API request is timeout' );
        }
        //检测签名
        $signstr=self::getSignStr($arrRequest, array('sign'));
        $signstr .= \Yii::$app->params['httpSecurityKey'];
        $mysign = md5($signstr);
        if($mysign!==$arrRequest['sign']){
            \Yii::error("sign error,md5str:{$signstr},my sign:{$mysign},req sign:{$arrRequest['sign']}");
            throw new Exception("sign error");
        }

        return true;
    }

    public static function getSignStr($arr,$notsignar) {
        if(!is_array($arr)){
            \Yii::warning('getSignstr is not array');
            throw new \Exception('getSignstr is not array');
        }
        ksort($arr);
        $str = '';
        foreach($arr as $key=>$val){
            if(!in_array($key,$notsignar)){
                $str .= $key.'='.stripslashes($val);
            }else{
                continue;
            }
        }
        return $str;
    }

}
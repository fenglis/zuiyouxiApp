<?php
/**
 * 全局通用接口
 */

namespace app\components;

use PHPUnit\Framework\Exception;
use Yii;
use yii\log\Logger;
use yii\base\Behavior;
use yii\web\Response;


class Util extends Behavior {

    public static function getArrRequest()
    {
        $arrRequest = [];

        if(\Yii::$app->request->isPost){
            $arrRequest = \Yii::$app->request->post();
        } elseif(\Yii::$app->request->isGet) {
            $arrRequest = \Yii::$app->request->get();
        } else {
            \Yii::warning('not support request method');
            throw new Exception('not support request method');
        }

        return $arrRequest;
    }




    /**
     * 处理请求过来的get或post参数
     * @param $arrRequest
     * @param $key
     * @param $type
     * @param bool $strict
     */
    public static function getParameter($arrRequest, $key, $type, $strict = true)
    {
        if(! isset($arrRequest[$key])) {
            if($strict) {
                Yii::error("key: {$key} not found in request");
                throw new Exception('getParameter is error');
            }
            return null;
        }

        $value = $arrRequest[$key];
        switch ($type) {
            case 'int' :
                return intval($value);
            case 'string' :
                return trim ( $value );
            case 'bool' :
                return ! empty ( $value );
            case 'float' :
                return floatval ( $value );
            case 'array' :
                return is_array($value)?$value:array();
            default :
                Yii::warning ( "unsupported type: {$type}");
                throw new Exception ( 'getParameter unsupported type' );
        }
    }

    public static function responseJson()
    {
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
    }

    public static function getClientIp()
    {
        $realip = '0.0.0.0';
        if (isset ( $_SERVER ['HTTP_X_FORWARDED_FOR'] ))
        {
            $arr = explode ( ',', $_SERVER ['HTTP_X_FORWARDED_FOR'] );
            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ( $arr as $ip )
            {
                $ip = trim ( $ip );
                if ($ip != 'unknown')
                {
                    $realip = $ip;
                    break;
                }
            }
        }
        elseif (isset ( $_SERVER ['HTTP_CLIENT_IP'] ))
        {
            $realip = $_SERVER ['HTTP_CLIENT_IP'];
        }
        else if (isset ( $_SERVER ['REMOTE_ADDR'] ))
        {
            $realip = $_SERVER ['REMOTE_ADDR'];
        }

        return $realip;
    }

    public static function getmd5str($params)
    {

        if (! isset ( $params ['pid'] ) || empty ( $params ['pid'] )) {
            $params ['pid'] == "\'\'";
        }
        ksort ( $params );
        $tmp = '';
        foreach ( $params as $key => &$val ) {
            if (in_array ( $key, array(
                'pid',
                'action',
                'ts'
            ) ) ) {
                $tmp .= $key . $val;
            }
        }
        Yii::info("sign is {$tmp}" . 'platform_ZuiGame' );
        $params ['sig'] = md5 ( $tmp . 'platform_ZuiGame' );
        if ($params ['pid'] == "\'\'") {
            unset ( $params ['pid'] );
        }
        return $params;

    }

}
<?php
/***************************************************************************
 *
 * Copyright (c) 2016 babeltime.com, Inc. All Rights Reserved
 * $Id: $
 *
 **************************************************************************/
/**
 *
 * @Author: $LastChangedBy: (machao@babeltime.com) $
 * @Version: $LastChangedRevision:$
 * @LastDate: $LastChangedDate:$
 * @file: $HeadURL:$
 *
 **/

namespace btldapsdk;

class Bt_ldap_sdk_helper
{    
    //加密签名
    public static function enCode ($type, $params, $appKey)
    {
        $tmp = '';
        
        foreach ($params as $key=>$value)
        {
            $tmp .= $key.$value;
        }
        
        $tmp .= $appKey;
        
        switch ($type) {
            default:
                return md5($tmp);
                break;
        }
    }
    
    //发送网络请求
    public static function http ( $url, $postdata )
    {
        if ( is_array($postdata) )
        {
            $postdata = http_build_query($postdata);
        }

        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,$url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt_array ( $curl_handle,  
                array (
                        CURLOPT_POSTFIELDS => $postdata, 
                        CURLOPT_POST => true,
				        CURLOPT_HTTPGET => false )
                );
        $query = curl_exec($curl_handle);
        curl_close($curl_handle);

        return $query;
    }
    
    //获取北京时间
    public static function getChinaTime() {
        
        $timezone_out = @date_default_timezone_get();

        date_default_timezone_set('Asia/Shanghai');
        $chinaTime = time();
    
        @date_default_timezone_set($timezone_out);
        return $chinaTime;
    }
    
    public static function getTokenSign($appid, $appkey, $token, $type='md5')
    {
        $data = array();
        $data['appid'] = $appid;
        $data['token'] = $token;
        $data['ip'] = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'';
        $data['ts'] = Bt_ldap_sdk_helper::getChinaTime();
        $data['timezone'] = @date_default_timezone_get();
        
        $data['sign'] = Bt_ldap_sdk_helper::enCode($type, $data, $appkey);
        
        return $data;
    }
}


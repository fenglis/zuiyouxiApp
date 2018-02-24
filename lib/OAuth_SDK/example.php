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
session_start();
use btldapsdk\Bt_ldap_sdk;

require_once 'index.php';

$config = [
    'appid' => 0,
    'appkey'   => 'b8694d827c0f13f22ed3bc',
    'env'   => 'dev',
];

$bt = new Bt_ldap_sdk($config);

if ( !empty($_GET['logout']) )
{
    $result = $bt->setLogout();
    
    if($result['status'] == true){
        echo '<script >alert("退出成功")</script>';
    }
}
elseif ( !empty($_GET['login']) || !empty($_GET['BabelTimeToken']) )
{
    $result = $bt->oauth();
    
    if ( $result['status'] )
    {
        echo '登录成功 欢迎' . $result['info']['username'] . '</br></br>';
        echo '<a href="?repasswd=1">修改密码</a></br>';
        echo '<a href="?mobile=1">修改手机绑定</a></br>';
        echo '<a href="?logout=1">退出</a></br>';
    }
    else
    {
        echo '<script >alert("登录失败")</script>';
    }
}elseif (!empty($_GET['repasswd']))
{
    $bt->rePasswd();
}elseif (!empty($_GET['mobile']))
{
    $bt->mobileBind();
}

if ( !$bt->isLogin() )
{
    echo '<a href="?login=1">登录</a>';
}
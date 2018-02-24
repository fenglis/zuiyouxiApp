<?php
/***************************************************************************
 *
 * Copyright (c) 2010 babeltime.com, Inc. All Rights Reserved
 * $Id$
 *
 **************************************************************************/

/**
 * @file $HeadURL$
 * @author $Author$(hoping@babeltime.com)
 * @date $Date$
 * @version $Revision$
 * @brief
 *
 **/
require_once ('Passport.cfgc.php');
require_once ('global.func.php');
require_once ('HTTPClient.php');

function ssoSetLoginCookie($uid, $passwd ,$agent='')
{
    if($agent!=''){
        $USER_AGENT = $agent;
    }else{
        if(isset($_SERVER ['HTTP_USER_AGENT'])){
            $USER_AGENT = $_SERVER ['HTTP_USER_AGENT'];
        }else{
            $USER_AGENT = '';
        }
    }
	dsetcookie ( 'cookietime', PassportConfig::COOKIE_TIME, PassportConfig::COOKIE_EXPIRE );
	//$auth_key = md5 ( PassportConfig::SHARED_KEY . $USER_AGENT );
	$auth_key = PassportConfig::AUTH_KEY;
	$authcode = authcode ( "$passwd\t\t$uid", 'ENCODE', $auth_key );
    Logger::debug('ssoSetLoginCookie : auth_key:'.$auth_key.' value:'.$authcode);
    Logger::debug('ssoSetLoginCookie : passwd:'.$passwd.' uid:'.$uid);
	dsetcookie ( 'auth', $authcode, PassportConfig::COOKIE_TIME, 1, true );
	dsetcookie ( 'sid' );
}

function ssoGetLoginCookie($uid, $passwd,$agent='')
{
    if($agent!=''){
        $USER_AGENT = $agent;
    }else{
        if(isset($_SERVER ['HTTP_USER_AGENT'])){
            $USER_AGENT = $_SERVER ['HTTP_USER_AGENT'];
        }else{
            $USER_AGENT = '';
        }
    }
    $return = array();
	$return[] = getdsetcookie ( 'cookietime', PassportConfig::COOKIE_TIME, PassportConfig::COOKIE_EXPIRE );
	$auth_key = md5 ( PassportConfig::SHARED_KEY . $USER_AGENT );
	$authcode = authcode ( "$passwd\t\t$uid", 'ENCODE', $auth_key );
    Logger::debug('ssoSetLoginCookie : auth_key:'.$auth_key.' value:'.$authcode);
	$return[] = getdsetcookie ( 'auth', $authcode, PassportConfig::COOKIE_TIME, 1, true );
    return $return;
}

/**
 * 清除cookie里存储的数据
 */
function ssoClearCookies()
{
	clearcookies();
}

/**
 * 生成cookie里存储的passwd
 */
function ssoGenCookiePasswd()
{

	return md5 ( random ( 10 ) );
}

/**
 * 获取salt值
 * @return string
 */
function ssoGetSalt()
{

	return substr ( uniqid ( rand () ), - 6 );
}

/**
 * 获取真正的用户密码
 * @param string $passwd
 * @param string $salt
 */
function ssoGetRealPasswd($passwd, $salt)
{

	return md5 ( md5 ( $passwd ) . $salt );
}

/**
 * 获取当前登录的用户uid
 * @return uid
 */
function ssoGetLoginUid()
{

	if (empty ( $_COOKIE [PassportConfig::COOKIE_PREFIX . 'auth'] ))
	{
		return 0;
	}
	else
	{
        if(isset($_SERVER ['HTTP_USER_AGENT'])){
            $USER_AGENT = $_SERVER ['HTTP_USER_AGENT'];
        }else{
            $USER_AGENT = '';
        }
		$auth_key = md5 ( PassportConfig::SHARED_KEY . $USER_AGENT );
		$auth = $_COOKIE [PassportConfig::COOKIE_PREFIX . 'auth'];
        $ainfo = daddslashes (explode ( "\t", authcode ( $auth, 'DECODE', $auth_key ) ), 1 );
        if(empty($ainfo[0])){
            return ;
        }else{
                list ( $passwd, $secques, $uid ) = $ainfo;
        }

		//TODO 查询用户表，看passwd与uid是否匹配
	}

	return $uid;
}

function ssoRegisterBBS($registerUrl, $uid, $uname, $email, $password, $cookiePasswd)
{
	//return true;
    if(isset($_SERVER ['HTTP_USER_AGENT'])){
        $USER_AGENT = $_SERVER ['HTTP_USER_AGENT'];
    }else{
        $USER_AGENT = '';
    }
	$auth_key = md5 ( PassportConfig::SHARED_KEY . $USER_AGENT );
	$hash = substr ( md5 ( substr ( time (), 0, - 7 ) . '0' . $auth_key ), 8, 8 );
	$arrRequest = array ('activationauth' => '', 'email' => $email, 'handlekey' => 'register',
			'password' => $password, 'password2' => $password,
			'referer' => PassportConfig::REGISTER_REFERER, 'username' => $uname, 'formhash' => $hash,
			'register_uid' => $uid, 'bbs_passwd' => $cookiePasswd );
    Logger::debug('ssoRegisterBBS:'.print_r($arrRequest,true));
    $client = new HTTPClient ( $registerUrl );
    $client->setHeader ( 'User-Agent', $USER_AGENT );
    $ret = $client->post ( http_build_query ( $arrRequest ) );
    Logger::debug('ssoRegisterBBS return: uid-'.$uid.' uname-'.$uname.' return-'.$ret);
    if (strstr ( $ret, 'register_succeed' ))
    {
        return true;
    }
    else
    {
        return false;
    }
}

//login();

/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */

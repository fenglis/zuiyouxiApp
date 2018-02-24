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

class PassportConfig
{

	//cookie的生效时间
	const COOKIE_TIME = 2592000;

	//cookie的失效时间
	const COOKIE_EXPIRE = 31536000;

	//cookie前缀
	const COOKIE_PREFIX = 'BqQ_';
	//const COOKIE_PREFIX = 'zuiyouxi_766f_';

	//cookie作用域
	const COOKIE_DOMAIN = '.zuiyouxi.com';

	//cookie作用路径
	const COOKIE_PATH = '/';

	//用于计算密码的共享key
	const SHARED_KEY = 'a7c98bTwjj13hNJ3';
	
	const AUTH_KEY = 'u1C8le80WaB7e7Aab0g2D9y6f7A264z8C0Gczed0r6m9Ec80z995w55cI5p8seP9';

	//注册所使用的referer
	const REGISTER_REFERER = 'http://bbs.hzw.zuiyouxi.com/bbs/notice.php?filter=systempm';

	//注册所使用的URL
	//const REGISTER_URL = 'http://bbs.hzw.zuiyouxi.com/bbs/register.php?regsubmit=yes&inajax=1';
	const REGISTER_URL = 'http://bbs.zuiyouxi.com:9001/bbs/register.php?regsubmit=yes&inajax=1';
}

$cookiepre = PassportConfig::COOKIE_PREFIX;
$cookiedomain = PassportConfig::COOKIE_DOMAIN;
$cookiepath = PassportConfig::COOKIE_PATH;
$timestamp = time ();

/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */

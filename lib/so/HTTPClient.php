<?php
namespace HTTPClient;

/***************************************************************************
 *
 * Copyright (c) 2010 babeltime.com, Inc. All Rights Reserved
 * $Id: HTTPClient.class.php 18199 2012-04-08 04:45:24Z HaopingBai $
 *
 **************************************************************************/

/**
 * @file $HeadURL: svn://192.168.1.80:3698/C/trunk/pirate/rpcfw/lib/HTTPClient.class.php $
 * @author $Author: HaopingBai $(hoping@babeltime.com)
 * @date $Date: 2012-04-08 12:45:24 +0800 (星期日, 08 四月 2012) $
 * @version $Revision: 18199 $
 * @brief
 *
 **/

class HTTPClient
{

	private $conn;

	private $arrCookie;

	private $arrHeader;

	private $connectTimeout;

	private $executeTimeout;

	private $targetURL;

	const STATUS_OK = 200;

	public function __construct($url)
	{

		$this->reset ();
		$this->conn = curl_init ();
		$this->targetURL = $url;
		$this->checkError ( 'curl_init', $this->conn );
	}

	public function reset()
	{

		if (! empty ( $this->conn ))
		{
			curl_close ( $this->conn );
		}
		$this->conn = null;
		$this->arrCookie = array ();
		$this->arrHeader = array ();
		$this->connectTimeout = 25;
		$this->executeTimeout = 25;
	}

	private function checkError($method, $ret)
	{

		if (! empty ( $ret ))
		{
			return;
		}
		throw new Exception ( $method. ' network' );
	}

	public function setCookie($name, $value)
	{

		$this->arrCookie [] = sprintf ( "%s=%s", $name, $value );
	}

	public function setConnectTimeout($connectTimeout)
	{

		$this->connectTimeout = $connectTimeout;
	}

	public function setExecuteTimeout($executeTimeout)
	{

		$this->executeTimeout = $executeTimeout;
	}

	public function setHeader($key, $value)
	{

		$this->arrHeader [] = sprintf ( "%s: %s", $key, $value );
	}

	public function post($postData)
	{

		$arrOpts = array (CURLOPT_POSTFIELDS => $postData, CURLOPT_POST => true,
				CURLOPT_HTTPGET => false );
		return $this->execute ( $arrOpts );
	}

	public function get()
	{

		$arrOpts = array (CURLOPT_HTTPGET => true );
		return $this->execute ( $arrOpts );
	}

	private function execute($arrOpts)
	{

		$arrOpts [CURLOPT_RETURNTRANSFER] = true;
		$arrOpts [CURLOPT_CONNECTTIMEOUT] = $this->connectTimeout;
		$arrOpts [CURLOPT_TIMEOUT] = $this->executeTimeout;
		$arrOpts [CURLOPT_URL] = $this->targetURL;

		if (! empty ( $this->arrHeader ))
		{
			$arrOpts [CURLOPT_HTTPHEADER] = $this->arrHeader;
		}

		if (! empty ( $this->arrCookie ))
		{
			$arrOpts [CURLOPT_COOKIE] = implode ( '; ', $this->arrCookie );
		}
		$ret = curl_setopt_array ( $this->conn, $arrOpts );
		$this->checkError ( 'curl_setopt_array', $ret );
		$respData = curl_exec ( $this->conn );
		$status = curl_getinfo ( $this->conn, CURLINFO_HTTP_CODE );

		if ($status != self::STATUS_OK)
		{
			throw new \Exception ( 'inter :: '.$status.' '.date('Ymd H:i:s')  );
		}
		$this->checkError ( 'curl_exec', $respData );
		return $respData;
	}
}

/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */

<?php
/***************************************************************************
 *
 * Copyright (c) 2016 babeltime.com, Inc. All Rights Reserved
 * $Id: $
 *
 **************************************************************************/
/**
 * @Author: $LastChangedBy: (machao@babeltime.com) $
 * @Version: $LastChangedRevision:$
 * @LastDate: $LastChangedDate:$
 * @file: $HeadURL:$
 */
namespace btldapsdk;

class Bt_ldap_sdk implements Bt_ldap_sdk_interface
{
    private $appid;

    private $appkey;

    private $type;
    
    private $env = 'production';

    private $callback;

    private $sessionName = 'BabelTimeOAuthLogin';

    private $getParamName = 'BabelTimeToken';

    public function __construct(Array $config)
    {
        $this->setConfig($config);
    }

    public function setSessionName($name)
    {
        $this->sessionName = $name;
    }

    public function getSessionName()
    {
        return $this->sessionName;
    }
    
    public function getUrl ($module) 
    {
        if ($this->env   == 'production') {
            $url = 'https://bouncer.babeltime.com/';
        } else {
            $url = 'http://192.168.99.100:5000/';
        }
        
        return $url . $module;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \btldapsdk\Bt_ldap_sdk_interface::setConfig()
     */
    public function setConfig(Array $config)
    {
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \btldapsdk\Bt_ldap_sdk_interface::isLogin()
     */
    public function isLogin()
    {
        return ! empty($_SESSION[$this->sessionName]) && ! empty($_SESSION[$this->getParamName]) ? $_SESSION[$this->sessionName] : null;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \btldapsdk\Bt_ldap_sdk_interface::setLogin()
     */
    public function setLogin($info)
    {
        if (! $info) {
            throw new \Exception('info err');
        }
        
        $_SESSION[$this->getParamName] = trim($_GET[$this->getParamName]);
        $_SESSION[$this->sessionName] = $info;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \btldapsdk\Bt_ldap_sdk_interface::setLogout()
     */
    public function setLogout()
    {
        if ($this->isLogin()) {
            
            $data = Bt_ldap_sdk_helper::getTokenSign($this->appid, $this->appkey, $_SESSION[$this->getParamName], $this->type);
            
            $url = $this->getUrl('user') . '/logout';
            
            $result = Bt_ldap_sdk_helper::http($url, $data);

            $result = json_decode($result, true);
            
            unset($_SESSION[$this->sessionName]);
            unset($_SESSION[$this->getParamName]);
            return $result;
        }
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \btldapsdk\Bt_ldap_sdk_interface::oauth()
     */
    public function oauth()
    {
        if ($this->isLogin()) {
            return $this->isLogin();
        }

        if (empty($_GET[$this->getParamName])) {
            $this->login();
        }
        
        $token = $_GET[$this->getParamName];
        
        if (($result = $this->checkToken($token)) && $result['status'] == true) {
            $this->setLogin($result);
        }

        return $result;
    }

    public function rePasswd()
    {
        $goto = $this->getUrl('user') . '/repasswd?' . $this->getSign();
        
        header('Location:' . $goto);
        exit();
    }

    public function mobileBind()
    {
        $goto = $this->getUrl('mobile'). '/bind_index/?' . $this->getSign();
        
        header('Location:' . $goto);
        exit();
    }

    /**
     * 转到登陆页面
     *
     * {@inheritDoc}
     *
     * @see \btldapsdk\Bt_ldap_sdk_interface::login()
     */
    public function login()
    {
        $goto = $this->getUrl('user') . '/login?' . $this->getSign();
        
        header('Location:' . $goto);
        exit();
    }

    public function getSign()
    {
        $redirect = '';
        
        if (isset($_SERVER['HTTPS'])) {
            $redirect .= 'https://';
        } else {
            $redirect .= 'http://';
        }
        if (isset($_SERVER['HTTP_HOST'])) {
            $host = $_SERVER['HTTP_HOST'];
        } else {
            throw new \Exception('host now set');
        }
        $redirect .= $host . $_SERVER['REQUEST_URI'];
        
        $data = array(
            'appid' => $this->appid,
            'ts' => Bt_ldap_sdk_helper::getChinaTime(),
            'redirect' => $redirect,
            'timezone' => @date_default_timezone_get()
        );
        
        $data['sign'] = Bt_ldap_sdk_helper::enCode($this->type, $data, $this->appkey);
        
        return http_build_query($data);
    }

    public function checkToken($token)
    {
        $data = Bt_ldap_sdk_helper::getTokenSign($this->appid, $this->appkey, $token, $this->type);
        
        $url = $this->getUrl('token') . '/check';

        $result = Bt_ldap_sdk_helper::http($url, $data);

        return json_decode($result, true);
    }

    public function getInfo($token, array $fields)
    {
        $fields = implode(',', $fields);
        
        $data = 'token?=' . $token . '&fields=' . $fields;
        $url = $this->getUrl('user') . '/getInfo';
        return Bt_ldap_sdk_helper::http($data, $url);
    }
}
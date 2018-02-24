<?php

namespace app\controllers\api;

use app\components\Util;
use app\components\ErrorCode;
use app\components\BabelCrypt;
use HTTPClient\HTTPClient;
use PHPUnit\Framework\Exception;
use Yii;
use yii\caching\Cache;
use yii\filters\AccessControl;
use yii\web\Controller;

require_once '../lib/so/index.php';

class PlayerController extends Controller
{
    /**
     * 用户登陆接口
     */
    public function actionLogin()
    {
        try {
            Util::responseJson(); //设置返回json
            $arrRequest = Util::getArrRequest();
            $username = Util::getParameter($arrRequest, 'username', 'string');
            $password = Util::getParameter($arrRequest, 'password', 'string');
            if (empty($username) || empty($password)){
                return [
                    'errid'=> ErrorCode::NECESSARY_ITEM,
                    'errmsg'=> ErrorCode::$msgArr[ErrorCode::NECESSARY_ITEM],
                ];
            }

            $result = self::login($username, $password);
            return $result;

        } catch (Exception $e) {
            Yii::warning($e->getMessage());
            return [
                'errid'=> ErrorCode::HTTP_PARAMS_ILLEGAL,
                'errmsg'=> ErrorCode::$msgArr[ErrorCode::HTTP_PARAMS_ILLEGAL],
            ];
        }
    }

    public static function login($username, $password)
    {
        $params['action'] = 'login';
        $params['ts'] = time();
        $params['pid'] = '';
        $params = Util::getmd5str($params);  //获取md5加密

        // 手机号形式的登陆
        if (preg_match("/^1[3|4|5|7|8][0-9]{9}$/", $username)) {
            $isMobile = 1;
        } else {
            $isMobile = 0;
        }

        $datastr = "username={$username}&password={$password}&email=&pid={$params['pid']}&action={$params['action']}&sig={$params['sig']}&ts={$params['ts']}&isMobile={$isMobile}";
        $httpClient = new HTTPClient (\yii::$app->params['callBackUrl'] . $datastr);
        $result = unserialize($httpClient->get());
        try {
            $result = unserialize($httpClient->get());
        } catch (Exception $e) {
            return [
                'errid' => ErrorCode::REQUEST_TIMEOUT,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::REQUEST_TIMEOUT],
            ];
        }

        if(!empty($result) && (int)$result['status'] === 1) {
            return [
                'errid' => ErrorCode::OK,
                'errmsg' => $result['message'],
                'pname' => $result['username'],
                'bindmobile' => strval($result ['mobile']),
                'pid' => BabelCrypt::encryptNumber($result['pid']),
                'isbind' => $result['mobile_status']
            ];
        } else {
            return [
                'errid' => ErrorCode::LOGIN_FAILURE,
                'errmsg' => $result['message'],
                'pname' => '',
                'bindmobile' => '0',
                'pid' => '',
                'isbind' => '0'
            ];
        }
    }

    /**
     * 密码找回获取验证码
     * @return array
     */
    public function actionGetmobilerandcode()
    {
        Util::responseJson();
        try {
            $arrRequest = Util::getArrRequest();
            $mobileNum = Util::getParameter( $arrRequest, 'mobilenum', 'string');
            $username = util::getParameter($arrRequest, 'username', 'string',false);
            $action = Util::getParameter($arrRequest, 'a', 'string');
        } catch (Exception $e) {
            return [
                'errid' => ErrorCode::NECESSARY_ITEM,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::NECESSARY_ITEM],
            ];
        }
        $returnMsg = self::sendCodeToMobile($mobileNum, '', $username,$bind = 'send', $action);
        if (isset($returnMsg['status']) && $returnMsg[ 'status' ] == 1) {
            return [
                'errid' => ErrorCode::OK,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::OK],
                'code'=>$returnMsg['code'],
            ];
        } else {
            Yii::warning("sendmessage error:{$returnMsg}");
            return array(
                'errid'=> ErrorCode::SIGN_UNAUTHORIZAION,
                'errmsg'=> empty($returnMsg['message']) ? $returnMsg['errmsg'] : $returnMsg['message'],
            );
        }
    }

    /**
     * 快速注册获取验证码
     * @param $mobile_num
     * @param string $pid
     * @param string $username
     * @param string $bind
     * @param string $a
     * @return array|mixed
     */
    public static function sendCodeToMobile($mobile_num, $pid = '', $username = '', $bind = 'send', $a = 'bind')
    {
        $cache = Yii::$app->getCache();
        if (!preg_match("/^1[3|4|5|8][0-9]{9}$/", $mobile_num)) {
            $ret['errmsg'] = '请输入有效手机号！';
            $ret['errid'] = 301;
            return $ret;
        }

        if ($cache->get(strval($mobile_num))) {
            $ret['errmsg'] = '今天已经发送过短信，不能重复发送';
            $ret['errid'] = 302;
            return $ret;
        }
        $ip = Util::getClientIp();
        if($cache->get($ip)) {
            $ret['errmsg'] = '您发送短信太频繁，请稍后再试';
            $ret['errid'] = 303;
            return $ret;
        }
        $params['action'] = $bind;
        $params['ts'] = time();
        $params['pid'] = $pid;
        $params = Util::getmd5str($params);
        $datastr = "mobile={$mobile_num}&action={$bind}&pid={$pid}&sig={$params['sig']}&ts={$params['ts']}&a={$a}&username={$username}";
        $httpClient = new HTTPClient (\yii::$app->params['callBackUrl'] . $datastr);
        try {
            $result = unserialize($httpClient->get());
        } catch (Exception $e) {
            return ['status' => 99, 'message' => '验证码请求失败'];
        }

        if (isset($result['status']) && $result['status'] == 1) {
            $cache->set($ip, '1', Yii::$app->params['SAVE_CODE_CACHE_TIMEOUT']);
            $cache->set(strval($mobile_num), '1', Yii::$app->params['SAVE_CODE_CACHE_TIMEOUT']);
            $cache->set(Yii::$app->params['MEMPRE']."_code_{$a}_".$mobile_num,$result ['code'], 86400);
        }

        return $result;
    }


    /**
     * 注册接口， 用于接收用户名或手机号的注册
     */
    public function actionRegister()
    {
        Util::responseJson();
        try{
            $arrRequest = Util::getArrRequest();
            $username = Util::getParameter($arrRequest, 'username', 'string');
            $password = Util::getParameter($arrRequest, 'password', 'string');
            $code = Util::getParameter($arrRequest, 'code', 'string' );
            $mobile = trim(Util::getParameter ($arrRequest, 'mobile', 'string'));
        }catch (Exception $e){
            return [
                'errid' => ErrorCode::NECESSARY_ITEM,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::NECESSARY_ITEM],
            ];
        }
        $result = self::register($username, $password, $code, $mobile);
        return $result;
    }

    public static function register($username, $password, $code, $mobile, $a = "reg")
    {
        $cache = Yii::$app->getCache();
        $user_receive_rand_code = $cache->get(Yii::$app->params['MEMPRE']."_code_{$a}_".$mobile);
        if (empty($user_receive_rand_code) || $user_receive_rand_code != $code) {
            return [
                'errid' => ErrorCode::SIGN_UNAUTHORIZAION,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::SIGN_UNAUTHORIZAION],
                'pid' => 0,
                'pname' => ''
            ];
        }

        $params['action'] = 'reg';
        $params['hid'] = 1;
        $params['ts'] = time();
        $params['pid'] = '';
        $params['projectid'] = 999;
        $params = Util::getmd5str($params);
        $datastr = "action={$params['action']}&username={$username}&password={$password}&repassword={$password}" .
            "&code={$code}&sig={$params['sig']}&ts={$params['ts']}&pid={$params['pid']}&mobile={$mobile}" .
            "&projectid={$params ['projectid']}&hid={$params['hid']}";

        $httpClient = new HTTPClient(yii::$app->params['callBackUrl'] . $datastr);
        try {
            $result = unserialize($httpClient->get());
        } catch (Exception $e) {
            return [
                'errid' => ErrorCode::REQUEST_TIMEOUT,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::REQUEST_TIMEOUT],
            ];
        }

        if (!empty($result) && (int)$result['status'] === 1) {
            // 正确登陆后的返回
            return [
                'errid' => ErrorCode::OK,
                'errmsg' => $result['message'],
                'pname' => $username,
                'bindmobile' => strval($mobile),
                'pid' => BabelCrypt::encryptNumber($result ['pid'])
            ];
        } else {
            return array(
                'errid' => ErrorCode::REGISTER_FAILURE,
                'errmsg' => $result['message'],
                'pname' => '',
                'bindmobile' => '0',
                'pid' => ''
            );
        }
    }

    /**
     * 找回(忘记)密码, 第二步设置新密码
     *
     * @return array
     */
    public function actionRecoverpassword()
    {
        Util::responseJson();
        try{
            $arrRequest = Util::getArrRequest();
            $username = Util::getParameter($arrRequest, 'username', 'string');
            $newpassword = Util::getParameter($arrRequest, 'newpassword', 'string');
            $code = Util::getParameter($arrRequest, 'code', 'string');
            $mobile = Util::getParameter($arrRequest, 'mobile', 'string');
        }catch (Exception $e){
            return [
                'errid' => ErrorCode::NECESSARY_ITEM,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::NECESSARY_ITEM],
            ];
        }
        $result = self::recoverPassword($username, $newpassword, $code, $mobile);
        return $result;
    }


    public static function recoverPassword($username, $newpassword, $code, $mobile, $a="repasswd")
    {
        $cache = Yii::$app->getCache();
        $user_receive_rand_code = $cache->get(Yii::$app->params['MEMPRE']."_code_{$a}_".$mobile);
        if (empty($user_receive_rand_code) || $user_receive_rand_code != $code) {
            return [
                'errid' => ErrorCode::SIGN_UNAUTHORIZAION,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::SIGN_UNAUTHORIZAION],
                'pid' => 0,
                'pname' => ''
            ];
        }
        $params['action'] = 'rePassword';
        $params['ts'] = time ();
        $params['pid'] = '';
        $params = Util::getmd5str($params);
        $datastr = "action={$params['action']}&username={$username}&password={$newpassword}&repassword={$newpassword}&code={$code}&sig={$params['sig']}&ts={$params['ts']}&pid={$params['pid']}&mobile={$mobile}";
        $httpClient = new HTTPClient(yii::$app->params['callBackUrl'] . $datastr);
        try {
            $result = unserialize ($httpClient->get());
        } catch ( Exception $e ) {
            return [
                'errid' => ErrorCode::REQUEST_TIMEOUT,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::REQUEST_TIMEOUT],
            ];
        }
        if ((int)$result['status'] === 1 ) {
            // 正确登陆后的返回
            return [
                'errid'=> ErrorCode::OK,
                'errmsg'=> $result['message'],
                'pname'=> $username,
                'bindmobile'=> strval($mobile),
                'pid'=> BabelCrypt::encryptNumber($result['pid'])
            ];
        } else {
            return [
                'errid'=> ErrorCode::GET_PASSWORD_FAILURE,
                'errmsg'=> $result['message'],
                'pname'=> '',
                'bindmobile'=> '0',
                'pid'=> ''
            ];
        }
    }

    /**
     * 修改密码，用于用户已经登陆后，对密码做的修改
     *
     * @param array $arrRequest
     */
    public function actionModifypassword()
    {
        Util::responseJson();
        try{
            $arrRequest = Util::getArrRequest();
            $oldpassword = md5(Util::getParameter($arrRequest, 'password', 'string'));
            $newpassword = Util::getParameter($arrRequest, 'newpassword', 'string');
            $pid =  Util::getParameter($arrRequest, 'pid', 'pid') ;
            $username = Util::getParameter($arrRequest, 'username', 'string');
            if( empty($newpassword) ){
                Yii::error("new password not allow empty.");
                return [
                    'errid'=>ErrorCode::RESET_PASSWORD_EMPTY,
                    'errmsg'=>ErrorCode::$msgArr[ErrorCode::RESET_PASSWORD_EMPTY],
                ];
            }
        }catch (Exception $e){
            return [
                'errid' => ErrorCode::NECESSARY_ITEM,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::NECESSARY_ITEM]
            ];
        }

        $result = self::modifyPassword($oldpassword, $newpassword, $pid, $username);
        return $result;
    }

    public static function modifyPassword($oldpassword, $newpassword, $pid, $username)
    {
        $params['action'] = 'renewpass';
        $params['ts'] = time();
        $params['pid'] = $pid;
        $params = Util::getmd5str($params);

        $datastr = "action={$params['action']}&username={$username}&passwordNew={$newpassword}&passwordRenew={$newpassword}&passwordOld={$oldpassword}&sig={$params['sig']}&ts={$params['ts']}&pid={$pid}";
        $httpClient = new HTTPClient(yii::$app->params['callBackUrl'] . $datastr);
        try {
            $result = unserialize ($httpClient->get());
        } catch ( Exception $e ) {
            return [
                'errid' => ErrorCode::REQUEST_TIMEOUT,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::REQUEST_TIMEOUT]
            ];
        }

        if(empty($result['pid'])){
            return [
                'errid'=> ErrorCode::MODIFY_PASSWORD_FAILURE,
                'errmsg'=> $result['msg'],
                'pid'=> BabelCrypt::encryptNumber($pid)
            ];
        }else{
            // 正确登陆后的返回
            return [
                'errid'=> ErrorCode::OK,
                'errmsg'=> $result['msg'],
                'pid'=> BabelCrypt::encryptNumber($pid)
            ];
        }
    }

    /**
     * 绑定手机号
     */
    public function actionBindmobilenumber()
    {
        Util::responseJson();
        $arrRequest = Util::getArrRequest();
        $username = Util::getParameter($arrRequest, 'username', 'string',  false);
        $pid = BabelCrypt::decryptNumber(Util::getParameter($arrRequest, 'pid', 'string', false));
        $password = Util::getParameter($arrRequest, 'password', 'string', false);
        $action = Util::getParameter($arrRequest, 'action', 'string');
        $mobile = Util::getParameter($arrRequest, 'mobile', 'string' ,false);
        $code = Util::getParameter($arrRequest, 'code', 'string', false);
        $omobile = Util::getParameter($arrRequest, 'omobile', 'string', false);
        $ocode = Util::getParameter($arrRequest, 'ocode', 'string', false);
        $a = Util::getParameter($arrRequest, 'a', 'string', false);
        if($action === 'send') {
            //发送验证码
            if(!empty($username)) {
                if(empty($mobile) || empty($pid)|| empty($a)){
                    return [
                        'errid' => ErrorCode::NECESSARY_ITEM,
                        'errmsg' => ErrorCode::$msgArr[ErrorCode::NECESSARY_ITEM]
                    ];
                }
                $returnMsg = self::sendCodeToMobile($mobile, $pid, $username, 'send', $a);
                if ( $returnMsg [ 'status' ] == 1 ) {
                    return [
                        'errid'=> ErrorCode::OK,
                        'errmsg'=> ErrorCode::$msgArr[ErrorCode::SEND_CODE_SUCCESS],
                        'code'=>$returnMsg['code']
                    ];
                } else {
                    return [
                        'errid'=> ErrorCode::SIGN_UNAUTHORIZAION,
                        'errmsg'=>$returnMsg['message']
                    ];
                }
            } else {
                return [
                    'errid'=> ErrorCode::USER_EXIST,
                    'errmsg'=> ErrorCode::$msgArr[ErrorCode::USER_EXIST]
                ];
            }
        } elseif ($action === 'bind') {
            //绑定手机
            if(empty($mobile) || empty($pid)|| empty($username)|| empty($code)){
                return [
                    'errid' => ErrorCode::NECESSARY_ITEM,
                    'errmsg' => ErrorCode::$msgArr[ErrorCode::NECESSARY_ITEM]
                ];
            }

            return self::bindPhone($username, $mobile, $code, $action, $pid);
        } elseif ($action === 'rebind') {
            // 用户重新绑定手机接口
            if(empty($mobile) || empty($pid)|| empty($username)|| empty($code)|| empty($omobile) || empty($ocode)){
                return [
                    'errid' => ErrorCode::NECESSARY_ITEM,
                    'errmsg' => ErrorCode::$msgArr[ErrorCode::NECESSARY_ITEM]
                ];
            }
            return self::rebind($mobile,$username,$omobile,$action,$pid,$code,$ocode, "rebindnew");
        } elseif ( $action == 'authorization' ) {
            //检查手机验证码
            if(empty($mobile) || empty($code) || empty($a)){
                return [
                    'errid' => ErrorCode::NECESSARY_ITEM,
                    'errmsg' => ErrorCode::$msgArr[ErrorCode::NECESSARY_ITEM]
                ];
            }
            return self::codeAuthorization($mobile,$code,$a);
        } else {
            return array(
                'errid'=> ErrDesc::HACKER_COME,
                'errmsg'=> ErrDesc::HACKER_COME_MSG
            );
        }
    }

    /**
     * 用户首次绑定手机接口
     * @param $username
     * @param $mobile
     * @param $code
     * @param $action
     * @param $pid
     * @return array
     */
    public static function bindPhone($username, $mobile, $code, $action, $pid, $a="bind")
    {
        $cache = Yii::$app->getCache();
        $user_receive_rand_code =$cache->get(Yii::$app->params['MEMPRE'] ."_code_{$a}_".$mobile);
        if (empty($user_receive_rand_code) || $user_receive_rand_code != $code) {  //验证码不对
            return [
                'errid' => ErrorCode::SIGN_UNAUTHORIZAION,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::SIGN_UNAUTHORIZAION],
                'pid' => 0,
                'pname' => $username
            ];
        }
        $params['action'] = $action;
        $params['ts'] = time ();
        $params['pid'] = $pid;
        $params = Util::getmd5str($params);
        $datastr = "action={$params['action']}&pid={$pid}&code={$code}&mobile={$mobile}&sig={$params['sig']}&ts={$params['ts']}";
        $httpClient = new HTTPClient(yii::$app->params['callBackUrl'] . $datastr);
        try {
            $result = unserialize ($httpClient->get());
        } catch (Exception $e) {
            return [
                'errid' => ErrorCode::REQUEST_TIMEOUT,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::REQUEST_TIMEOUT]
            ];
        }
        if ((int)$result['status'] == 1) {
            // 正确登陆后的返回
            return [
                'errid'=> ErrorCode::OK,
                'errmsg'=> $result['message'],
                'bindmobile'=> strval($mobile),
                'pid'=> BabelCrypt::encryptNumber($pid),
                'pname'=> $username
            ];
        } else {
            return [
                'errid'=> ErrorCode::BIND_FAILURE,
                'errmsg'=> $result [ 'message' ],
                'bindmobile'=> "0",
                'pid'=> "",
                'pname'=> ""
            ];
        }
    }

    /**
     * 用户重新绑定手机接口
     */
    public static function rebind($mobile,$username,$omobile,$action,$pid,$code,$ocode,$a="rebind")
    {
        $cache = Yii::$app->getCache();
        $user_receive_rand_code =$cache->get(Yii::$app->params['MEMPRE']."_code_{$a}_".$mobile);
        if (empty($user_receive_rand_code) || $user_receive_rand_code != $code) {  //验证码不对
            return [
                'errid' => ErrorCode::SIGN_UNAUTHORIZAION,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::SIGN_UNAUTHORIZAION],
                'pid' => 0,
                'pname' => $username
            ];
        }

//        $ocodeCheck = $cache->get(Yii::$app->params['MEMPRE']."_code_rebind_".$omobile);
//        if($ocode != $ocodeCheck){
//            WebContext::getInstance ()-> setJson ();
//            return array(
//                'errid'=> ErrDesc::SIGN_UNAUTHORIZAION,
//                'errmsg'=> ErrDesc::SIGN_UNAUTHORIZAION_MSG,
//                'pid'=> 0,
//                'pname'=> $username
//            );
//        }
        // 验证成功，绑定用户手机号切***********************
        $params['action'] = $action;
        $params['pid'] = $pid;
        $params['ts'] = time();
        $params = Util::getmd5str($params);

        $datastr = "action={$params['action']}&pid={$pid}&code={$code}&mobile={$mobile}&sig={$params['sig']}" .
            "&ts={$params['ts']}&oldmobile={$omobile}&oldcode={$ocode}";

        $httpClient = new HTTPClient(yii::$app->params['callBackUrl'] . $datastr);
        try {
            $result = unserialize ($httpClient->get());
        } catch (Exception $e) {
            return [
                'errid' => ErrorCode::REQUEST_TIMEOUT,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::REQUEST_TIMEOUT]
            ];
        }
        if ((int)$result['status'] === 1) {
            // 正确登陆后的返回
            return [
                'errid'=> ErrorCode::OK,
                'errmsg'=> $result['message'],
                'bindmobile'=> strval($mobile),
                'pid'=> BabelCrypt::encryptNumber($pid),
                'pname'=> $username
            ];
        } else {
            return [
                'errid'=> ErrorCode::MODIFY_PASSWORD_FAILURE,
                'errmsg'=> $result [ 'message' ],
                'bindmobile'=> "0",
                'pid'=> "",
                'pname'=> ""
            ];
        }
    }

    public static function codeAuthorization($mobile,$code,$a)
    {
        $cache = Yii::$app->getCache();
        $user_receive_rand_code =$cache->get(Yii::$app->params['MEMPRE']."_code_{$a}_".$mobile);
        if (empty($user_receive_rand_code) || $user_receive_rand_code != $code) {  //验证码不对
            return [
                'errid' => ErrorCode::SIGN_UNAUTHORIZAION,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::SIGN_UNAUTHORIZAION],
                'pid' => '',
                'pname' => ''
            ];
        }

        return [
            'errid'=> ErrorCode::OK,
            'errmsg'=> "验证码正确"
        ];
    }

    public function actionCheckregcode()
    {
        Util::responseJson();
        $arrRequest = Util::getArrRequest();
        $mobile = Util::getParameter ( $arrRequest, 'mobile', 'string' , false);
        $code = Util::getParameter ( $arrRequest, 'code', 'string', false );
        $a = Util::getParameter ( $arrRequest, 'a', 'string', false );
        return self::codeAuthorization($mobile,$code,$a);
    }

    public function actionGettime()
    {
        Util::responseJson();
        return time();
    }


    public function actionWxlogin()
    {
        Util::responseJson();
        try{
            $arrRequest = Util::getArrRequest();
            $from = Util::getParameter($arrRequest, 'from', 'string');
            $openid = Util::getParameter($arrRequest, 'openid', 'string');

        }catch (Exception $e){
            return [
                'errid' => ErrorCode::NECESSARY_ITEM,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::NECESSARY_ITEM]
            ];
        }

        $result = self::wxLogin($from, $openid);
        return $result;
    }


    public static function wxLogin($from, $openid)
    {
        $params ['action'] = 'login';
        $params['openid'] = $openid;
        $params['name'] = $from;
        $params['hid'] = 1;
        $params['pid'] = 1;
        $params['logid'] = Util::genLogid();
        $params ['ts'] = time();
        $params['projectid'] = 1;
        $params = Util::getmd5str($params);


        $datastr = "action={$params['action']}&openid={$params['openid']}&name={$params['name']}&hid={$params['hid']}".
            "&logid={$params['logid']}&sig={$params['sig']}&pid={$params['pid']}&ts={$params['ts']}&projectid={$params['projectid']}";

        $httpClient = new HTTPClient(yii::$app->params['callBackUrl'] . $datastr);
        try {
            $result = unserialize ($httpClient->get());
        } catch (Exception $e) {
            return [
                'errid' => ErrorCode::REQUEST_TIMEOUT,
                'errmsg' => ErrorCode::$msgArr[ErrorCode::REQUEST_TIMEOUT]
            ];
        }

        if ($result ['status'] == 1) {
            return [
                'errid' => ErrorCode::OK,
                'errmsg' => $result ['message'],
                'pname' => $result['pname'],
                'userpid' => BabelCrypt::encryptNumber($result['pid']),
                'token'=>$result['password']
            ];
        } else {
            return [
                'errid' => ErrorCode::LOGIN_FAILURE,
                'errmsg' => $result ['message'],
                'pname' => '',
                'bindmobile' => '0',
                'pid' => ''
            ];
        }

    }

}
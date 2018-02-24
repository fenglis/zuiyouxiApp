<?php
/**
 * 全局错误码和错误信息定义
 */

namespace app\components;


use Yii;

class ErrorCode {
    const OK='0';// 成功  所有接口成功都是0
    const FAIL = '1';

    CONST USER_EXIST = 10001;
    CONST REGISTER_FAILURE = 10002;
    CONST NECESSARY_ITEM = 10004;
    CONST SIGN_UNAUTHORIZAION = 10005;
    CONST LOGIN_FAILURE = 10013;
    CONST GET_PASSWORD_FAILURE = 10014;
    CONST MODIFY_PASSWORD_FAILURE = 10015;
    CONST BIND_FAILURE = 10017;
    CONST SEND_CODE_SUCCESS = 10019;
    CONST RESET_PASSWORD_EMPTY = 10020;

    const HTTP_PARAMS_ILLEGAL = 20001;
    const HACKER_COME = 90002;
    CONST COMMENT_TIMES_TOO_FREQUENT = 30001;
    CONST COMMENTED = 30002;
    CONST FAVORITEED = 40001;
    CONST UNFAVORITEED = 40002;
    CONST CANCEL_FAVORIT = 40003;
    CONST REQUEST_TIMEOUT = 90012;

    public static $msgArr = array(
        self::OK=>'OK',
        self::FAIL=>'fail',
        self::HTTP_PARAMS_ILLEGAL=>'请求参数格式有误',
        self::HACKER_COME => 'hacker',
        self::COMMENT_TIMES_TOO_FREQUENT => '评论太频繁',
        self::COMMENTED => '用户已经评论',
        self::FAVORITEED => '用户已收藏',
        self::UNFAVORITEED => '用户未收藏',
        self::CANCEL_FAVORIT => '用户取消收藏',
        self::NECESSARY_ITEM => '必填项不能为空',
        self::REQUEST_TIMEOUT => '请求超时，请重试',
        self::LOGIN_FAILURE => '登陆失败',
        self::SIGN_UNAUTHORIZAION => '验证码非法',
        self::REGISTER_FAILURE => '注册失败',
        self::GET_PASSWORD_FAILURE => '找回密码有误',
        self::RESET_PASSWORD_EMPTY => '重置密码不能为空',
        self::MODIFY_PASSWORD_FAILURE => '修改密码有误',
        self::SEND_CODE_SUCCESS => '发送验证码成功',
        self::USER_EXIST => '用户已存在',
        self::BIND_FAILURE => '绑定有误',
    );
}
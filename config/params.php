<?php

return [

    'adminEmail' => 'admin@example.com',
    'bouncer' => [
        'appid' => 0,
        'appkey' => 'b8694d827c0f13f22ed3bc'
    ],
    'status' => [
        'ok' => 1,
        'fail' => 0,
    ],

    'platform' => [
        0 => 'ALL',
        1 => 'IOS',
        2 => 'Android',
    ],
    'os' => [
        1 => 'ios',
        2 => 'android',
    ],

    'comment_action' => [
        'reply' => 0,   //文章
        'vote' => 1,    //投票
        'recom' => 2,   //推荐
        'praise' => 3,  //点赞
    ],
    'comment_type' => [
        'article' => 1, //父评论
        'user' => 2,    //子评论
    ],

    'admins' => ['seven'],
    'attachUrl' => YII_ENV ? 'http://192.168.2.97:1097' : '',   #线下图片访问url
    'attachPath'=>'/home/pirate/var/static/zuiyouxiApp',# 图片上传路径
    'projectImage' => '/project/image', #游戏项目
    'advertImage' => '/advert/image', #广告
    'articleImage' => '/article/image', #文章图片
    'pollImage' => '/poll/image', #文章图片
    'recommendImage' => '/recommend/image',  #推荐阵容图片
    //'attachPath'=>'/home/pirate/static',# 图片上传路径
    'urlStaticPath'=>'/web/attached/image',
    'staticPath'=>'/zuiyouxiApp',# 图片上传路径
    'attachServer'=>'//static.zuiyouxi.com', # 图片HOST


    'apiTimeOut' => 600, //接口超时时间
    'noCheckUrlSignApi' => [],  #不需要检测签名的api
    'httpSecurityKey' => 'grl3afaf8aflf21034e1efeio',

    //api
    'COMMENT_LIST_NUM' => 12,  // 评论列表显示条数
    'callBackUrl' => YII_ENV ? 'http://192.168.1.174:10001/userMobileApi.php?' : 'http://192.168.8.233:10001/userMobileApi.php?', //用户验证
    'SAVE_CODE_CACHE_TIMEOUT'=> 10, //请求验证码间隔
    'MEMPRE'=> 'APP', //缓存前缀
];

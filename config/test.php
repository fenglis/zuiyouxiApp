<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/test_db.php');

$config = [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
	],
    ],
    "aliases" => [    
	    "@mdm/admin" => "@vendor/mdmsoft/yii2-admin",
    ],
    'as access' => [
	    'class' => 'mdm\admin\components\AccessControl',
	    'allowActions' => [
	    ]
    ],
    'components' => [
	    'authManager' => [
		    'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
		    "defaultRoles" => ["test"],    

        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
	"urlManager" => [    
		//用于表明urlManager是否启用URL美化功能，在Yii1.1中称为path格式URL，    
		// Yii2.0中改称美化。   
		// 默认不启用。但实际使用中，特别是产品环境，一般都会启用。   
		"enablePrettyUrl" => true,    
		// 是否启用严格解析，如启用严格解析，要求当前请求应至少匹配1个路由规则，    
		// 否则认为是无效路由。    
		// 这个选项仅在 enablePrettyUrl 启用后才有效。    
		"enableStrictParsing" => false,    
		// 是否在URL中显示入口脚本。是对美化功能的进一步补充。    
		"showScriptName" => false,    
		// 指定续接在URL后面的一个后缀，如 .html 之类的。仅在 enablePrettyUrl 启用时有效。    
		"suffix" => "",    
		"rules" => [        
			"<controller:\w+>/<id:\d+>"=>"<controller>/view",  
			"<controller:\w+>/<action:\w+>"=>"<controller>/<action>"    
		],
	],
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            //这里是允许访问的action
            //controller/action
            '*'
        ]
    ],
    'params' => $params,
];

if (YII_DEBUG) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
	'allowedIPs' => ['*']
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;

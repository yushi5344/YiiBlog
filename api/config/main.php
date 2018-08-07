<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
	'language'=>'zh-CN',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
        ],
	    'response'=>[
	    	'class'=>'yii\web\Response',
		    'on beforeSend'=>function($event){
				$response=$event->sender;
				$response->data=[
					'success'=>$response->isSuccessful,
					'code'=>$response->getStatusCode(),
					'data'=>$response->data,
					'message'=>$response->statusText
				];
				$response->statusCode=200;
		    }
	    ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
	        'enableSession' => false,
//            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
//        'session' => [
//            // this is the name of the session cookie used for login on the backend
//            'name' => 'advanced-api',
//        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
	        'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
            	[
            		'class'=>'yii\rest\UrlRule',
		            'controller' => 'post',
		            'extraPatterns' => [
		            	'POST search'=>'search'
		            ],
	            ],
	            [
	            	'class'=>'yii\rest\UrlRule',
		            'controller' => 'top10',
		            'pluralize' => false  //如果为false，则url为http://api.blog.com/top10否则为http://api.blog.com/top10s
	            ],
	            [
	            	'class'=>'yii\rest\UrlRule',
		            'controller' => 'user',
		            'except' => ['delete','update','create','view'],
		            'pluralize' => false,
		            'extraPatterns' => [
		            	'POST login'=>'login',
		            	'POST signup'=>'signup',
		            ]
	            ],
            ],
        ],
    ],
    'params' => $params,
];

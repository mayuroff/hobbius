<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.




return array(
	'theme'=>'desktop', // requires you to copy the theme under your themes directory

	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Hobbius',
	'language'=>'ru',
	'charset'=>'utf-8',

	'defaultController' => 'sitepages/frontend',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.admin.components.*',
		'application.modules.admin.models.*',
	),

	'modules'=>array(
		'admin',
		'news',
		'sitepages',
		'catalog',
		/*'goodtovar',*/
		/*'assortment',*/
		/*'vacancy',*/
		/*'guestbook',*/
		'adminuser',
		/*'anketa',*/
		/*'seocatalog',*/
		'layouts',
		'masterclasses',
		'articles',
		/*'boxberry',*/
		/*'company',*/
	/**
		'gii'=>array(
            'generatorPaths'=>array(
                'bootstrap.gii',
            ),
        ),
		**/
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'generatorPaths'=>array(
                'bootstrap.gii',
            ),
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('217.21.221.122','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),
        'mobileDetect' => array(
            'class' => 'ext.MobileDetect.MobileDetect'
        ),

		'authManager' => array(
			// Будем использовать свой менеджер авторизации
			'class' => 'PhpAuthManager',
			// Роль по умолчанию. Все, кто не админы, модераторы и юзеры — гости.
			'defaultRoles' => array('guest'),
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('admin/default/login'),
			'class' => 'application.modules.admin.components.WebUser',
		),
		
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			
			'class'=>'UrlManager',
			
			'urlFormat'=>'path',
			'showScriptName' => false,
			'urlSuffix' => "/",
			'rules'=>array(
		
				//ajax
				'ajax/addressboxberry/' => 'ajax/addressboxberry',
				'ajax/basket/' => 'ajax/basket',
				'ajax/uploader/' => 'ajax/uploader',
				'ajax/crop/' => 'ajax/crop',
				'ajax/imageadd/' => 'ajax/imageadd',
				'ajax/basketprod/' => 'ajax/basketprod',
				'ajax/basketclear/' => 'ajax/basketclear',
				'ajax/addcomment/' => 'ajax/addcomment',
				'ajax/addaction/' => 'ajax/addaction',
				'ajax/vrating/' => 'ajax/vrating',
				'ajax/code/' => 'ajax/code',
				'ajax/expect/' => 'ajax/expect',
				'ajax/getdelivery/' => 'ajax/getdelivery',

				'aboutfreshtime/' => 'site/aboutfreshtime',
				'sitemap/<id:\d+>/'=>'site/sitemap',
				'sitemap/'=>'site/sitemap',
				'upmodels/'=>'site/upmodels',

				//для админки
				'admin/login/' => 'admin/default/login',
				'admin/' => 'admin/default/index',
				'admin/logout/' => 'site/logout',
		
                'admin/nabors/' => 'admin/default/nabors',
        		'admin/ajaxnabor/' => 'admin/default/ajaxnabor',
        		'admin/ajaxnaboradd/' => 'admin/default/ajaxnaboradd',
        		'admin/ajaxnabordel/' => 'admin/default/ajaxnabordel',
				
				//для админки - Новости
				'news/backend/<action:update|delete|create|all>' => 'news/backend/<action>',
				'masterclasses/backend/<action:index|admin|view|update|delete|create|all>' => 'masterclasses/backend/<action>',
				'articles/backend/<action:index|admin|view|update|delete|create|all>' => 'articles/backend/<action>',
				'sitepages/backend/<action:act|update|content|create|index>' => 'sitepages/backend/<action>',
				'assortment/backend/<action:assort|shops|up|down|upshop|downshop|update|updateshop|del|delshop|create|createshop|tovars|check>' => 'assortment/backend/<action>',
				'vacancy/backend/<action:index|up|down|del|create|update>' => 'vacancy/backend/<action>',
				'guestbook/backend/<action:index|update|del>' => 'guestbook/backend/<action>',
				'adminuser/backend/<action:index|update|create|del>' => 'adminuser/backend/<action>',
				'seocatalog/backend/<action:index|update|create|admin|view>' => 'seocatalog/backend/<action>',
				'layouts/backend/<action:update|create|admin|del>' => 'layouts/backend/<action>',
				'boxberry/backend/<action:update|create|admin|index|view|delete>' => 'boxberry/backend/<action>',
				'boxberry/backendcourier/<action:update|create|admin|index|view|delete>' => 'boxberry/backendcourier/<action>',
				'company/backend/<action:update|create|admin|index|view|delete>' => 'company/backend/<action>',
                'catalog/backend/<action:nabors>' => 'catalog/backend/<action>',
		
				//для captcha
				'admin/default/captcha/<v:[\w_\/-]+>'=>'admin/default/captcha',
		
				//каталог
				'catalog/' => 'catalog/frontend/list/',
				'/<id:good_[\w_\/-]+>/'=>'catalog/frontend/item',
				
				//статьи
				'articles/' => 'articles/frontend/list/',
				'articles/<id:[\w_\/-]+>' => 'articles/frontend/item',
		
				//все остальные страницы
				'<category:[\w_\/-]+>/'=>'sitepages/frontend/category',
		
				//для gii
				/*
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				*/
			),
		),

		// MySQL database
		'db'=>require(dirname(__FILE__) . '/db.php'),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		//'adminEmail'=>'webmaster@example.com',
		
		'base_url'=>'http://miadolla.ru/',
	
		'update_base'=>'',
	
		//Для корзины
		'basket_act'=>'',
		
		//VK виджет группы
		'vkontakte'=>'',
		
		//Яндекс ТИЦ
		'ya_tiz'=>'',
		
		//Mail rating
		'mail_rating'=>"",
	
		//Google Analytics
		'google_analytics'=>"",
	
		//Яндекс метрика
		'yandex_metrika'=>'',
	
		//Для уведомления о новом заказе
		'orders_email'=>'khaziyev_m@sb-service.ru',
	
		//Для уведомления о новом отзыве в Гостевой книге
		'guestbook_email'=>'khaziyev_m@sb-service.ru',

		//Для уведомления о Анкете в вакансиях
		'anketa_email'=>'khaziyev_m@sb-service.ru',
	
	
		//для тестовой версии, раскоментировать
		//'base_url'=>'http://move.miadolla.ru/',
		//'vkontakte'=>'VKONTAKTE - тестовая версия сайта!',
		'mail_rating'=>'',
		'google_analytics'=>'',
		'yandex_metrika'=>'',
		'orders_email'=>'khaziyev_m@sb-service.ru',
		'guestbook_email'=>'',
		'anketa_email'=>'',
	
	
	
	),
);
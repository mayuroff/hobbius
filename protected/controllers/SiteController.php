<?php

class SiteController extends Controller
{
	public $pageDescription = '';
    public $pageKeywords = '';
    public $mainpage = 0;
    
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		//$this->layout='//layouts/error';
		$this->layout='//layouts/layoutSiteMain';

		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	//База данных обновлена: ( что это означает? )  
	public function actionAboutfreshtime()
	{
		echo "
		<style>
			*
			{
				font-family:Arial, Helvetica, sans-serif;
				font-size:11px;
				line-height:16px;
			}
		</style>
		<p>Вся информация о товарах, ценах и наличии в магазинах хранится в базе данных сайта, которая является точной копией базы данных нашей складской системы. Информация на сайте обновляется раз в сутки, поэтому допускается, что могут быть некоторые расхождения в ценах или наличии. Дата и время указывают на то, когда произошло последнее обновление.</p>
			";
	}
	
	//Sitemap
	public function actionSitemap()
	{
		$id = 0;
		if (isset($_GET['id'])) $id = $_GET['id'];
		$this->render('sitemap',array('id'=>$id));
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
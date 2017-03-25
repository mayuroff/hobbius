<?php

class FrontendController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/layoutSitePage';
	
    public $mainpage = 0;
    public $pageTitle = '';
    public $pageKeywords = '';
	public $pageDescription = '';
    public $title = '';
    public $content = '';
    public $pageClass = '';
    
	public function init(){
	    // SET THEME desktop/mobile
        $device = Yii::app()->mobileDetect;
        if($device->isMobile() || $device->isIphone()){
            Yii::app()->theme = 'mobile';    
        }
        elseif($device->isTablet()){
            Yii::app()->theme = 'tablet'; 
        }
        else{
            Yii::app()->theme = 'desktop'; 
        }
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','category','show'),
				'users'=>array('*'),
			),
		);
	}

	public function actionCategory($category)
    {
		$page = $this->loadModel($category);
		
		if ($page->status > 0)
			throw new CHttpException(404,'The requested page does not exist.');
        
		$page_main = $this->loadModel('main');
		
		$this->pageTitle = $page->title_short." | ".$page_main->title_short;
		$this->pageDescription = $page->description;
    	$this->pageKeywords = $page->keywords;
        
        $this->title = $page->title_for_admin;
        $this->content = $page->content;
        
        switch ($category) {
            case 'wheretobuy':
                $this->layout = '//layouts/layoutSitePage1';
                $this->pageClass = 'wheretobuy';
                break;
            
            default:
                $this->layout = '//layouts/layoutSiteMain';
                break;
        }
		
        $layoutFile = $this->getLayoutFile($this->layout);              
        $this->renderFile($layoutFile); 
    }
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$url = $_SERVER['REQUEST_URI'];
		$rep_url = str_replace('index.php', '', $url);
		if($url!==$rep_url)
		{
		    throw new CHttpException(404,'The requested page does not exist.');
		    exit();
		} 
			
		$page = $this->loadModel('main');
        
    	$this->mainpage = 1;
        
		$this->pageTitle = $page->title_short;
		$this->pageDescription = $page->description;
    	$this->pageKeywords = $page->keywords;
        
		$this->title = $page->title_for_admin;
		$this->content = $page->content;
        
        $this->layout = '//layouts/layoutSiteMain';
        $layoutFile = $this->getLayoutFile($this->layout);              
        $this->renderFile($layoutFile);	
    }

	
	public function loadModel($id)
	{
		$model=FrontendSitepages::model()->findBySlug($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}

<?php

class FrontendController extends Controller
{
    public $layout='//layouts/layoutSitePage1';
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
                'actions'=>array('index','view'),
                'users'=>array('*'),
            ),
		);
	}

	/**
	 * Displays a particular article
	 * @param integer $id the ID of the article to be displayed
	 */
	public function actionItem($id){
	    
	    $page = $this->loadPage('articles');
	    $page_main = $this->loadPage('main');
        
	    $item = $this->loadModelById($id);
        
        $this->pageTitle = $page->title_short." | ".$page_main->title_short;
        $this->pageDescription = $page->description;
        $this->pageKeywords = $page->keywords;
        
        $this->title = $item->title;
        $this->content = $item->articles_tekst;
        
        $this->pageClass = 'article';
        
        $layoutFile = $this->getLayoutFile($this->layout);              
        $this->renderFile($layoutFile); 
	}

	/**
	 * Lists all articles
	 */
	public function actionList(){
	    
	    $page = $this->loadPage('articles');
	    $page_main = $this->loadPage('main');
        $content = '';
        
        $dataProvider = new CActiveDataProvider('Articles');
        $iterator = new CDataProviderIterator($dataProvider);
        foreach($iterator as $article) {
    
            $content .= '<div class="clearfix colelem" id="u17042">
                            <div class="shadow rgba-background Article_background grpelem" id="u17003"></div>
                            <div class="Articles clip_frame grpelem" id="u17026">
                                <img class="block" id="u17026_img" src="/src/img/losutnoe_shitie-crop-u17026.jpg?crc=399154671" alt="" width="160" height="160">
                            </div>
                            <div class="clearfix grpelem" id="u17039">
                                <div class="clearfix colelem" id="u17009-4">
                                    <p>'.$article->title.'</p>
                                </div>
                                <div class="clearfix colelem" id="u17006-4">
                                    <p>'.$article->short_tekst.'</p>
                                </div>
                                <a class="nonblock nontext transition clearfix colelem" id="u17036-4" href="/articles/'.$article->id.'">
                                    <p class="Podrobnee">
                                        Подробнее...
                                    </p>
                                </a>
                            </div>
                        </div>';
        }
        
        $this->pageTitle = $page->title_short." | ".$page_main->title_short;
        $this->pageDescription = $page->description;
        $this->pageKeywords = $page->keywords;
        
        $this->title = $page->title_for_admin;
        $this->content = $content;
        
        $this->pageClass = 'articles';
        
        $layoutFile = $this->getLayoutFile($this->layout);              
        $this->renderFile($layoutFile); 
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Articles the loaded model
	 * @throws CHttpException
	 */
	public function loadModelById($id)
	{
		$model=Articles::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    
    public function loadPage($uri)
    {
        $sql = "SELECT * FROM {{sitepages}} WHERE url_page = '".$uri."'";
        $command = Yii::app()->db->createCommand($sql);
        $row = $command->queryRow();
        if(!$row)
            throw new CHttpException(404,'The requested page does not exist.');
        
        return (object)$row;
    }
}

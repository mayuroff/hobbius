<?php

class BackendController extends ModuleAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

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
			/*
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			*/
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','create','update', 'content', 'act'),
				'roles'=>array('role_page'),
				'users'=>array('@'),
			),
			/*
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','update', 'content', 'act'),
				'users'=>array('admin'),
			),*/
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function translitUrl($str){
        $tr = array(
          "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
          "Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
          "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
          "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
          "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
          "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
          "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
          "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
          "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
          "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
          "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
          "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
          "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
          " "=> "_", "."=> "", "/"=> ""
        );
 
        if (preg_match('/[^A-Za-z0-9_\-]/', $str)) {
          $str = strtr($str,$tr);
          $str = preg_replace('/[^A-Za-z0-9_\-]/', '', $str);
        }
 
        return $str;
    }

	/**
	 * Создание страниц сайта для подраздела
	 */
	public function actionCreate($id)
	{
		$model=new Sitepages('add');
		$modelid=$this->loadModel($id);

		$model->parent_id = $modelid->id;
		
		if(isset($_POST['Sitepages']))
		{
			$model->attributes=$_POST['Sitepages'];
			$url_page = $model->url_page;
			$url_page = $this->translitUrl($url_page);
			$url_page_id = $modelid->url_page;
			if (strcmp($url_page_id,"main") == 0) $url_page_id = "";
			else $url_page_id = $url_page_id."/";
			if (strlen($url_page) > 0) $model->url_page = $url_page_id.$url_page;
			if ($model->save())
				$this->redirect(array('index'));
			else $model->url_page = $url_page;
		}

		$this->render('create',array(
			'model'=>$model,
			'modelid'=>$modelid,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->scenario = 'update';

		if(isset($_POST['Sitepages']))
		{
			$model->attributes=$_POST['Sitepages'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionContent($id)
	{
		$model=$this->loadModel($id);
		$model->scenario = 'content';

		if(isset($_POST['Sitepages']))
		{
			$model->attributes=$_POST['Sitepages'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('content',array(
			'model'=>$model,
		));
	}
	
	public function actionAct($id)
	{
		$model=$this->loadModel($id);

		$sql = "SELECT count(*) FROM {{sitepages}} WHERE ((url_page='".$model->url_page."') and (status=0))";
		$command=Yii::app()->db->createCommand($sql);
		$r=$command->queryScalar();
		if (($r==0) || ($model->status==0)) 
		{
			if ($model->status == 0) $status = 1;
			else $status = 0;
			$sql = "UPDATE {{sitepages}} SET status=".$status." WHERE (id=".$model->id.")";
			$command=Yii::app()->db->createCommand($sql);
			$r=$command->execute();
		}
	}

	public function loadPageForMas()
	{
		$mas = array();
		$sql = "SELECT * FROM {{sitepages}} ORDER BY parent_id,id";
		$command=Yii::app()->db->createCommand($sql);
		$dataReader=$command->query();
		foreach($dataReader as $row) 
			{
			$mas[] = Array($row['id'], $row['parent_id'], $row['url_page'], $row['title_for_admin'], $row['status']);
			}

		return $mas;
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataReader = $this->loadPageForMas();
		//$dataProvider=new CActiveDataProvider('Sitepages');
		$this->render('index',array(
			'dataReader'=>$dataReader,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Sitepages the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Sitepages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Sitepages $model the model to be validated
	 */
	 /*
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sitepages-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	*/
}

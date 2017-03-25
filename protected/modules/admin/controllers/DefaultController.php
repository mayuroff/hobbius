<?php

class DefaultController extends ModuleAdminController
{

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	public function actions(){
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
            ),
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
				'actions'=>array('login','view','captcha','nabors','ajaxnabor','ajaxnaboradd','ajaxnabordel'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
				'roles'=>array('moderator'),
			),
			/*
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),*/
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	//вывод 404 ошибок из БД
	public function actionIndex()
	{
		//$this->render('index');
		
		$model=new Error404('search');
		$model2=new Passselect('search2');
		$model->unsetAttributes();
		$this->render('index',array(
			'model'=>$model,
			'model2'=>$model2,
		));
		
		
	}
	
	public function actionNabors()
	{
		//$this->render('index');
		
		$model="";
		//new Error404('search');
		//$model->unsetAttributes();
		$this->render('nabors',array(
			'model'=>$model,
		));
	}
	public function actionAjaxnabordel()
	{
		if (!isset($_POST['id'])) throw new CHttpException(404,'The requested page does not exist.');
		if (!isset($_POST['iddel'])) throw new CHttpException(404,'The requested page does not exist.');
		if ( (isset($_POST['id'])) && (isset($_POST['iddel'])) )
		{
			$id = $_POST['id'];
			$iddel = $_POST['iddel'];
			$sql='DELETE FROM {{podobnye}} WHERE (id_nabor = '.$id.' and id_podob = '.$iddel.'); DELETE FROM {{podobnye}} WHERE (id_nabor = '.$iddel.' and id_podob = '.$id.');';
			$command=Yii::app()->db->createCommand($sql);
			$command->execute();
			echo "<script>$('#naboradd_".$iddel."').css('display','none');</script>";
		}
	}
	public function actionAjaxnaboradd()
	{
		if (!isset($_POST['id'])) throw new CHttpException(404,'The requested page does not exist.');
		if (!isset($_POST['idadd'])) throw new CHttpException(404,'The requested page does not exist.');
		if ( (isset($_POST['id'])) && (isset($_POST['idadd'])) )
		{
			$id = $_POST['id'];
			$idadd = $_POST['idadd'];
			
			function imga($filename,$pref)
			{
				$a=md5($filename);
				$path='/images/gamma'.$pref.'/'.$a[0].'/'.$a[1].'/'.$filename;
				return $path;
			}
			function imga2($filename,$pref)
			{
				$a=md5($filename);
				$path='./images/gamma'.$pref.'/'.$a[0].'/'.$a[1].'/'.$filename;
				return $path;
			}
			
			$img2 = "/src/img/opacity.png";
			if (file_exists(imga2("g".$idadd.'u.jpg',""))) {$img2 = imga("g".$idadd.'u.jpg',"");}
			if (file_exists(imga2("g".$idadd.'u.jpg',""))) {$img2 = imga("g".$idadd.'u.jpg',"");}
			
			$sql = 'SELECT * FROM {{podobnye}} where id_nabor='.$id.' and id_podob='.$idadd;
			$command=Yii::app()->db->createCommand($sql);
			$r=$command->query();
			if (sizeof($r) > 0)
			{
				//уже добавлен
				echo "<script>alert('Набор уже добавлен');</script>";
			} else {
				$sql='INSERT INTO {{podobnye}} (`id`, `id_nabor`, `id_podob`) VALUES (NULL, '.$id.', '.$idadd.'); INSERT INTO {{podobnye}} (`id`, `id_nabor`, `id_podob`) VALUES (NULL, '.$idadd.', '.$id.');';
				$command=Yii::app()->db->createCommand($sql);
				$command->execute();
				echo "<script>$('#nabor_add').append(\"<div class='nabors_podobie' style='display: block;' id='naboradd_".$idadd."'><a href='/catalog/good_".$idadd."' target='_blank'><img class='imgnab' src='".$img2."' alt=''></a><img onclick='nabor_del(".$id.",".$idadd.");' class='fkill' src='/src/img/kill.gif' title='УДАЛИТЬ'></div>\");</script>";
			}
		}
	}
	public function actionAjaxnabor()
	{
		if (!isset($_POST['id'])) throw new CHttpException(404,'The requested page does not exist.');
		
		if (isset($_POST['id']))
		{
			$time = strtotime("now");
			
			//поворот изображения
			function rotate_img($src, $dest, $degrees){
				if (!file_exists($src)) return false;
				$im = imagecreatefromjpeg($src);
				$rotated = imagerotate( $im, $degrees, 0);
				imagejpeg($rotated, $dest, 100);
				imagedestroy( $im );
				imagedestroy( $rotated );
			}
			$pathr = $_SERVER['DOCUMENT_ROOT'].'/images/comment/comm_'.$_POST['id'].'.jpg';
			$pathr_orig = $_SERVER['DOCUMENT_ROOT'].'/images/comment/original/comm_'.$_POST['id'].'.jpg';
			$pathrsm = $_SERVER['DOCUMENT_ROOT'].'/images/comment/comm_'.$_POST['id'].'_sm.jpg';
			if ($_POST['stor'] == 0) $degrees = 90; else $degrees = -90;
			rotate_img($pathr_orig, $pathr_orig, $degrees);
			rotate_img($pathrsm, $pathrsm, $degrees);
			
			//watermark
			$logo_file = $_SERVER['DOCUMENT_ROOT']."/src/img/miadolla-logo.png"; 
			$image_file = $pathr_orig; 
			$targetfile = $pathr; 
			$photo = imagecreatefromjpeg($image_file); 
			$fotoW = imagesx($photo); 
			$fotoH = imagesy($photo); 
			$logoImage = imagecreatefrompng($logo_file); 
			$logoW = imagesx($logoImage); 
			$logoH = imagesy($logoImage); 
			$photoFrame = imagecreatetruecolor($fotoW,$fotoH); 
			$dest_x = $fotoW - $logoW; 
			$dest_y = $fotoH - $logoH; 
			imagecopyresampled($photoFrame, $photo, 0, 0, 0, 0, $fotoW, $fotoH, $fotoW, $fotoH); 
			imagecopy($photoFrame, $logoImage, $dest_x, $dest_y, 0, 0, $logoW, $logoH); 
			imagejpeg($photoFrame, $targetfile);
			
			echo "<script>
			$('#".$_POST['id']." img').attr('src','/images/comment/comm_".$_POST['id']."_sm.jpg?v=".$time."');
			$('#".$_POST['id']." a').attr('href','/images/comment/comm_".$_POST['id'].".jpg?v=".$time."');
			</script>";
		}
	}
	
	public function actionLogin()
	{
		$model=new LoginForm;
		
		// if it is ajax validation request
	/*	if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}*/

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
}
<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Панель управления сайтом Miadolla.</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php Yii::app()->bootstrap->register(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('admin.assets') ); ?>/css/admin-styles.css" />
	<script type="text/javascript" src="<?php echo Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('admin.assets') ); ?>/js/admin.js"></script>
	<!--  <script type="text/javascript" src="<?php echo Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('admin.assets') ); ?>/js/jquery-1.8.3.min.js"></script>-->
	<script type="text/javascript" src="<?php echo Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('admin.assets') ); ?>/js/imageCrop/jquery.imagecrop.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('admin.assets') ); ?>/js/imageCrop/jquery.imagecrop.css">
</head>

<body>

<?php 

$arr = array();

if(!Yii::app()->user->isGuest)
{
	if(Yii::app()->user->checkAccess('role_news'))
		$arr[] = array('label'=>'Новости', 'url'=>Yii::app()->createUrl('news/backend/all'));
	if(Yii::app()->user->checkAccess('role_news'))
		$arr[] = array('label'=>'Мастер-классы', 'url'=>Yii::app()->createUrl('masterclasses/backend/admin'));
	if(Yii::app()->user->checkAccess('role_news'))
		$arr[] = array('label'=>'Статьи', 'url'=>Yii::app()->createUrl('articles/backend/admin'));
	if(Yii::app()->user->checkAccess('role_page'))
	    $arr[] = array('label'=>'Шаблоны сайта', 'url'=>Yii::app()->createUrl('layouts/backend/admin/'));
	if(Yii::app()->user->checkAccess('role_page'))
	    $arr[] = array('label'=>'Страницы сайта', 'url'=>Yii::app()->createUrl('sitepages/backend/index'));
	/*if(Yii::app()->user->checkAccess('role_page'))
	    $arr[] = array('label'=>'SEO каталог', 'url'=>Yii::app()->createUrl('seocatalog/backend/index'));
	if(Yii::app()->user->checkAccess('role_assort'))
		$arr[] = array('label'=>'Ассортимент по магазинам', 'url'=>Yii::app()->createUrl('assortment/backend/assort'));
	if(Yii::app()->user->checkAccess('role_kadr'))
		$arr[] = array('label'=>'Вакансии', 'url'=>Yii::app()->createUrl('vacancy/backend/index'));
	if(Yii::app()->user->checkAccess('role_guestbook'))
		$arr[] = array('label'=>'Гостевая книга', 'url'=>Yii::app()->createUrl('guestbook/backend/index'));*/
	if(Yii::app()->user->checkAccess('role_users'))
		$arr[] = array('label'=>'Пользователи', 'url'=>Yii::app()->createUrl('adminuser/backend/index'));
	if(Yii::app()->user->checkAccess('role_manager2'))
		$arr[] = array('label'=>'Управление наборами', 'url'=>Yii::app()->createUrl('admin/nabors'));
	/*if(Yii::app()->user->checkAccess('role_page'))
		$arr[] = array('label'=>'Boxberry', 'url'=>Yii::app()->createUrl('boxberry/backend/admin'));
	if(Yii::app()->user->checkAccess('role_page'))
		$arr[] = array('label'=>'Boxberry Couriers', 'url'=>Yii::app()->createUrl('boxberry/backendcourier/admin'));
	if(Yii::app()->user->checkAccess('role_page'))
		$arr[] = array('label'=>'Реквизиты магазинов', 'url'=>Yii::app()->createUrl('company/backend/admin'));*/
	$arr[] = array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest);
	$arr[] = array('label'=>'Выйти ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest);
}

$this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>$arr
        ),
    ),
)); ?>




<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
			'homeLink'=>CHtml::link('Администрирование',array('/admin')),
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		<br />Copyright &copy; <?php 
		echo date('Y'); 
		if(Yii::app()->user->isGuest) 
			echo ""; 
		else 
			echo " <b>web@firma-gamma.ru</b>";
		?><br/>All Rights Reserved.<br />
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>

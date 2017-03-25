<?php
/* @var $this BackendController */
/* @var $model Sitepages */

$this->breadcrumbs=array(
	'Страницы сайта'=>array('index'),
	'Добавить',
);

$this->menu=array(
	array('label'=>'Все страницы', 'url'=>array('index'), 'icon'=>'icon-list-alt'),
);
?>

<?php $this->renderPartial('_form_create', array('model'=>$model, 'modelid'=>$modelid)); ?>
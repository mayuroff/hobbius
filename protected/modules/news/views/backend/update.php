<?php
/* @var $this BackendController */
/* @var $model News */

$this->breadcrumbs=array(
	'Новости'=>array('all'),
	/*$model->title=>array('view','id'=>$model->id),*/
	'Редактирование',
);

$this->menu=array(
	array('label'=>'Добавить новость', 'url'=>array('create'), 'icon'=>'icon-plus-sign'),
	array('label'=>'Все новости', 'url'=>array('all'), 'icon'=>'icon-list-alt'),
);
?>

<h2>Редактировать новость</h2>

<?php $this->renderPartial('_form_update', array('model'=>$model)); ?>
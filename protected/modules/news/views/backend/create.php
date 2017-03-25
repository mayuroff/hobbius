<?php
/* @var $this BackendController */
/* @var $model News */

$this->breadcrumbs=array(
	'Новости'=>array('all'),
	'Добавить',
);

$this->menu=array(
	array('label'=>'Все новости', 'url'=>array('all'), 'icon'=>'icon-list-alt'),
);
?>

<h1>Добавить новость</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this BackendController */
/* @var $model Usersadmin */

$this->breadcrumbs=array(
	'Пользователи'=>array('index'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'Все пользователи', 'url'=>array('index')),
	array('label'=>'Создать пользователя', 'url'=>array('create')),
);
?>

<h2>Редактирование пользователя</h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
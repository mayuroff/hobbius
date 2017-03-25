<?php
/* @var $this BackendController */
/* @var $model Usersadmin */

$this->breadcrumbs=array(
	'Пользователи'=>array('index'),
	'Добавление пользователя',
);

$this->menu=array(
	array('label'=>'Все пользователи', 'url'=>array('index')),
);
?>

<h2>Добавить пользователя</h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
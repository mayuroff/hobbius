<?php
/* @var $this BackendController */
/* @var $model Masterclasses */

$this->breadcrumbs=array(
	'Masterclasses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Masterclasses', 'url'=>array('index')),
	array('label'=>'Manage Masterclasses', 'url'=>array('admin')),
);
?>

<h1>Create Masterclasses</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
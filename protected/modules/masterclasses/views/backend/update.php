<?php
/* @var $this BackendController */
/* @var $model Masterclasses */

$this->breadcrumbs=array(
	'Masterclasses'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Masterclasses', 'url'=>array('index')),
	array('label'=>'Create Masterclasses', 'url'=>array('create')),
	array('label'=>'View Masterclasses', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Masterclasses', 'url'=>array('admin')),
);
?>

<h1>Update Masterclasses <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form_update', array('model'=>$model)); ?>
<?php
/* @var $this BackendController */
/* @var $model Masterclasses */

$this->breadcrumbs=array(
	'Masterclasses'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Masterclasses', 'url'=>array('index')),
	array('label'=>'Create Masterclasses', 'url'=>array('create')),
	array('label'=>'Update Masterclasses', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Masterclasses', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Masterclasses', 'url'=>array('admin')),
);
?>

<h1>View Masterclasses #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'short_tekst',
		'tekst',
		'time',
	),
)); ?>

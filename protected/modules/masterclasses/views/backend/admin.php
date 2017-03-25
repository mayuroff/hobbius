<?php
/* @var $this BackendController */
/* @var $model Masterclasses */

$this->breadcrumbs=array(
	'Masterclasses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Masterclasses', 'url'=>array('index')),
	array('label'=>'Create Masterclasses', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#masterclasses-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Мастер-классы</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'masterclasses-grid',
	'dataProvider'=>$model->search(),

	'columns'=>array(
		'id',
		'title',
		'short_tekst',
		/*'tekst',
		'time',*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

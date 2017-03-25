<?php
/* @var $this BackendController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Masterclasses',
);

$this->menu=array(
	array('label'=>'Create Masterclasses', 'url'=>array('create')),
	array('label'=>'Manage Masterclasses', 'url'=>array('admin')),
);
?>

<h1>Masterclasses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

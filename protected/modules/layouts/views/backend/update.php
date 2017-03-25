<?php
/* @var $this BackendController */
/* @var $model TestLayouts */

$this->breadcrumbs=array(
	'Шаблоны сайта'=>array('admin'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'Добавить шаблон', 'url'=>array('create')),
	array('label'=>'Список шаблонов', 'url'=>array('admin')),
);
?>

<h2>Редактирование шаблона</h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
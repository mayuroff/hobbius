<?php
/* @var $this BackendController */
/* @var $model TestLayouts */

$this->breadcrumbs=array(
	'Шаблоны сайта'=>array('admin'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Добавить шаблон', 'url'=>array('create')),
	array('label'=>'Список шаблонов', 'url'=>array('admin')),
);
?>

<h2>Создание шаблона</h2>

<p>Еще физически создать здесь: themes/bootstrap/views/layouts/</p>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
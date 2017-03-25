<?php
/* @var $this BackendController */
/* @var $model News */

$this->breadcrumbs=array(
	'Новости',
);

$this->menu=array(
	/*array('label'=>'List News', 'url'=>array('index')),*/
	array('label'=>'Добавить новость', 'url'=>array('create'), 'icon'=>'icon-plus-sign'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#news-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2>Управление новостями</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'news-grid',
	'dataProvider'=>$model->search(),

	'columns'=>array(
        array(
            'name'  => 'Дата',
            'type'  => 'raw',
			'value' => 'date("d-m-Y",$data["time"])',
        ),
		array(
            'name'  => 'Заголовок',
            'type'  => 'raw',
			'value' => '$data["title"]',
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{update}{delete}',
			
		),
	),
)); ?>
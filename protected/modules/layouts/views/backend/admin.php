<?php
/* @var $this BackendController */
/* @var $model TestLayouts */

$this->breadcrumbs=array(
	'Шаблоны сайта',
);

$this->menu=array(
	array('label'=>'Добавить шаблон', 'url'=>array('create')),
);

?>

<h2>Шаблоны сайта</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'test-layouts-grid',
	'dataProvider'=>$model->search(),

	'columns'=>array(
		'id',
		'name',
				array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{act_del} {act_red}',
			'htmlOptions' => array('style' => 'width: 35px'),
			'buttons'=>array(
			
				'act_del'=>array(
                    'label'=>'Удалить',
					'icon'=>'icon-remove',
                    'url'=>'Yii::app()->createUrl("layouts/backend/del", array("id"=>$data["id"]))',
					/*'visible'=>'$data["status"] > 0',*/
                    'options'=>array(
						'confirm' => 'Вы уверены, что хотите удалить?',
                        'ajax' => array(
                            'type' => 'get', 
							'url'=>'js:$(this).attr("href")', 
							'success' => 'js:function(data) {$.fn.yiiGridView.update("test-layouts-grid");}'
                        ),
                    ),
				),

				'act_red'=>array(
					'label'=>'Редактировать',
					'icon'=>'icon-pencil',
					'url'=>'Yii::app()->createUrl("layouts/backend/update", array("id"=>$data["id"]))',
					'options'=>array(
						'id'=>'\'button_for_id_\'.$data->id',
					),
				),
			),
		),
	),
)); ?>

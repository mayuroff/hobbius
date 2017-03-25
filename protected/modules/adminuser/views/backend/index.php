<?php
/* @var $this BackendController */
/* @var $model Usersadmin */

$this->breadcrumbs=array(
	'Пользователи',
);

$this->menu=array(
	array('label'=>'Создать пользователя', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#usersadmin-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2>Управление пользователями</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'usersadmin-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'id',
		'username',
		/*'password',*/
		'role',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{act_red} {act_del}',
			'htmlOptions' => array('style' => 'width: 35px'),
			'buttons'=>array(
			
				'act_del'=>array(
                    'label'=>'Удалить',
					'icon'=>'icon-remove',
                    'url'=>'Yii::app()->createUrl("adminuser/backend/del", array("id"=>$data["id"]))',
					/*'visible'=>'$data["status"] > 0',*/
                    'options'=>array(
						'confirm' => 'Вы уверены, что хотите удалить?',
                        'ajax' => array(
                            'type' => 'get', 
							'url'=>'js:$(this).attr("href")', 
							'success' => 'js:function(data) {$.fn.yiiGridView.update("usersadmin-grid");}'
                        ),
                    ),
				),
				
				'act_red'=>array(
					'label'=>'Редактировать',
					'icon'=>'icon-pencil',
					'url'=>'Yii::app()->createUrl("adminuser/backend/update", array("id"=>$data["id"]))',
					'options'=>array(
						'id'=>'\'button_for_id_\'.$data->id',
					),
				),
			),
		),
	),
)); ?>

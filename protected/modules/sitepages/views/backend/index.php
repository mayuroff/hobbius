<?php
/* @var $this BackendController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Страницы сайта',
);
/*
$this->menu=array(
	array('label'=>'Create Sitepages', 'url'=>array('create')),
	array('label'=>'Manage Sitepages', 'url'=>array('admin')),
);*/
?>

<h2>Страницы сайта</h2>

<?php

$items = array();

$iconn = "icon-play";

function catalog($cat,$parent_id,$level) //$level переменная для определения уровня вложенности раздела
	{
	global $items;
	if (@is_array($cat))
		{
		$len_i = count($cat);
		$level++;
		for($i = 0; $i < $len_i; $i++)
			{
			if ($cat[$i][1] == $parent_id) 
				{
				$padding = ($level-1) * 30;
				if (strcmp($cat[$i][2],"main") == 0) $cat[$i][2] = "";
				$url = Yii::app()->createAbsoluteUrl('sitepages/frontendsite/category', array('category'=>$cat[$i][2]));
				$url = CHtml::link($url,$url,array("target" => "_blank"));
				$perem = "<div style=\"padding: 0 0 0 ".$padding."px;\"><b>".$cat[$i][3]."</b></div>";
				$items[] = array('id' => $cat[$i][0], 'title'=>$perem, 'url'=>$url, 'description' => 'url', 'status' => $cat[$i][4]);
				catalog($cat,$cat[$i][0],$level);
				}
			}
		}
	return $items; 
	}



/*
 * Структура массива dataReader:
 * Уровень | id | Наименование | Выбран | Текст
*/

$len_i = count($dataReader);
if ($len_i > 0)
	{
	$len_j = count($dataReader[0]);
	if ($len_j == 5)
		{
		$items2 = catalog($dataReader,0,0);
		}
	else echo "<h3>Какая то ошибка!</h3>";
	}
else echo "<h3>Массив пустой!</h3>";

?>




<?php 
    $itemsProvider = new CArrayDataProvider($items2, array(  
        'pagination' => array(  
            'pageSize' => 100,  
        ),  
    ));  


	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sitepages-grid',
	'dataProvider'=>$itemsProvider,
	
	'columns'=>array(
		'id',
        array(
            'name'  => 'Название',
            'type'  => 'raw',
			'value' => '$data["title"]',
        ),
		array(
            'name'  => 'Публичный url',
            'type'  => 'raw',
			'value' => '$data["url"]',
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			/*'template' => '{update}{delete}',*/
			'template'=>'{act_off} {act_on} {myButtonAdd} {myButton} {myButtonContent}',
			'htmlOptions' => array('style' => 'width: 70px'),
			/*'evaluateID'=>true,*/
			'buttons'=>array(
			
				'act_off'=>array(
                    'label'=>'Отключено',
					'icon'=>'icon-remove-circle',
                    'url'=>'Yii::app()->createUrl("sitepages/backend/act", array("id"=>$data["id"]))',
					'visible'=>'$data["status"] > 0',
                    'options'=>array(
						'confirm' => 'Вы уверены, что хотите опубликовать страницу?',
                        'ajax' => array(
                            'type' => 'get', 
							'url'=>'js:$(this).attr("href")', 
							'success' => 'js:function(data) {$.fn.yiiGridView.update("sitepages-grid");}'
                        ),
                    ),
				),
			
				'act_on'=>array(
                    'label'=>'Опубликовано',
					'icon'=>'icon-ok-sign',
                    'url'=>'Yii::app()->createUrl("sitepages/backend/act", array("id"=>$data["id"]))',
					'visible'=>'$data["status"] == 0',
					'onclick'=>'$("#jobDialog").dialog("open"); return false;',
                    'options'=>array(
						'confirm' => 'Вы уверены, что хотите отключить страницу?',
                        'ajax' => array(
                            'type' => 'get', 
							'url'=>'js:$(this).attr("href")', 
							'success' => 'js:function(data) {$(this).attr("href"); $.fn.yiiGridView.update("sitepages-grid");}'
                        ),
                    ),
				),
				
				'myButtonContent'=>array(
					'label'=>'Контент',
					'icon'=>'icon-file',
					'url'=>'Yii::app()->createUrl("sitepages/backend/content", array("id"=>$data["id"]))',
					'options'=>array(
						'id'=>'\'button_for_id_\'.$data->id',
					),
				),
				'myButtonAdd'=>array(
					'label'=>'Добавить подраздел',
					'icon'=>'icon-plus',
					'url'=>'Yii::app()->createUrl("sitepages/backend/create", array("id"=>$data["id"]))',
					'options'=>array(
						'id'=>'\'button_for_id_\'.$data->id',
					),
				),
				'myButton'=>array(
					'label'=>'Редактировать',
					'icon'=>'icon-wrench',
					'url'=>'Yii::app()->createUrl("sitepages/backend/update", array("id"=>$data["id"]))',
					'options'=>array(
						'id'=>'\'button_for_id_\'.$data->id',
					),
				),
			),
		),
	),
)); ?>
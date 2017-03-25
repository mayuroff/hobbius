<?php
/* @var $this BackendController */
/* @var $model Sitepages */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sitepages-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php 
	echo "<h3>".$model->title_for_admin."</h3>"; 
	$url_page = $model->url_page;
	if (strcmp($url_page,"main") == 0) $url_page = "";
	$url =Yii::app()->createAbsoluteUrl('sitepages/frontendsite/category', array('category'=>$url_page));
	echo CHtml::link($url,$url,array("target" => "_blank"))."<br /><br />";
	?>

	<?php echo $form->errorSummary($model); ?>

	<div class="rowold">
		<?php echo $form->labelEx($model,'Заголовок для "Хлебных крошек"'); echo $form->error($model,'title_for_admin'); ?>
		<?php echo $form->textField($model,'title_for_admin',array('style' => 'width:600px;','size'=>60,'maxlength'=>300)); ?>
	</div>

	<div class="rowold">
		<?php echo $form->labelEx($model,'Title (meta)'); echo $form->error($model,'title_short'); ?>
		<?php echo $form->textField($model,'title_short',array('style' => 'width:600px;','size'=>260,'maxlength'=>300)); ?>
	</div>

	<div class="rowold">
		<?php echo $form->labelEx($model,'Keywords (meta)'); echo $form->error($model,'keywords'); ?>
		<?php echo $form->textField($model,'keywords',array('style' => 'width:600px;','size'=>260,'maxlength'=>300)); ?>
	</div>

	<div class="rowold">
		<?php echo $form->labelEx($model,'Description (meta)'); echo $form->error($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('style' => 'width:600px;','size'=>260,'maxlength'=>300)); ?>
	</div>
	
	<div class="rowold">
		<?php echo $form->labelEx($model,'Шаблон'); echo $form->error($model,'layout'); ?>
		<?php echo $form->dropDownList($model,'layout', array('Для главной', 'Остальные страницы')); ?>
	</div>

	<div class="rowold buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
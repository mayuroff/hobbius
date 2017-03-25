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
		<?php echo $form->labelEx($model,'Контент:'); ?>
		<?php echo $form->textArea($model,'content', array('style' => 'width:800px;', 'rows'=>25)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="rowold buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
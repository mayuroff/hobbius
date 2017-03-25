<?php
/* @var $this BackendController */
/* @var $model TestLayouts */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'test-layouts-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="rowold">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('style' => 'width:500px;', 'size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="rowold">
		<?php echo $form->labelEx($model,'layout'); ?>
		<?php echo $form->textArea($model,'layout',array('style' => 'width:700px;', 'rows'=>16, 'cols'=>50)); ?>
		<?php echo $form->error($model,'layout'); ?>
	</div>

	<div class="rowold buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
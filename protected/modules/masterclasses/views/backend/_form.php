<?php
/* @var $this BackendController */
/* @var $model Masterclasses */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'masterclasses-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="rowold">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('style' => 'width:600px;', 'size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="rowold">
		<?php echo $form->labelEx($model,'short_tekst'); ?>
		<?php echo $form->textArea($model,'short_tekst',array('rows'=>6, 'style' => 'width:600px;')); ?>
		<?php echo $form->error($model,'short_tekst'); ?>
	</div>

	<div class="rowold">
		<?php echo $form->labelEx($model,'tekst'); ?>
		<?php $this->widget('application.components.fieldEditor', array(
				'model' => $model,
				'field' => 'tekst',
				'type' => 'text-editor'
			)); ?>
		<?php echo $form->error($model,'tekst'); ?>
	</div>
	<br />
	<div class="rowold buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
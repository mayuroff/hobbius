<?php
/* @var $this BackendController */
/* @var $model News */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="rowold">
		<?php echo $form->labelEx($model,'Заголовок'); ?>
		<?php echo $form->textField($model,'title',array('style' => 'width:600px;', 'size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	
	<div class="rowold">
		<?php echo $form->labelEx($model,'Короткий текст новости на Главной'); ?>
		<?php echo $form->textField($model,'short_news',array('style' => 'width:600px;', 'size'=>60,'maxlength'=>600)); ?>
		<?php echo $form->error($model,'short_news'); ?>
	</div>
	
	<div class="rowold">
		<?php echo $form->labelEx($model,'Новость'); ?>
		<?php $this->widget('application.components.fieldEditor', array(
				'model' => $model,
				'field' => 'news',
				'type' => 'text-editor'
			)); ?>
		<?php echo $form->error($model,'news'); ?>
	</div>
	
	<div class="rowold">
		<?php echo "<br />Дата отмены показа (формат Год-месяц-день ч:м:с); По умолчанию:0; Пример:2014-07-25 14:28:02"; ?>
		<?php echo $form->textField($model,'timeend',array('style' => 'width:600px;', 'size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'timeend'); ?>
	</div>

	<div class="rowold buttons">
		<br />
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
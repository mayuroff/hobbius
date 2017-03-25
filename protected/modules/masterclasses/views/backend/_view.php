<?php
/* @var $this BackendController */
/* @var $data Masterclasses */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('short_tekst')); ?>:</b>
	<?php echo CHtml::encode($data->short_tekst); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tekst')); ?>:</b>
	<?php echo CHtml::encode($data->tekst); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode($data->time); ?>
	<br />


</div>
<?php
/* @var $this BackendController */
/* @var $model Masterclasses */
/* @var $form CActiveForm */
?>

<div class="form">

<p><b>1) Изображение превью на Главной (165x165):</b></p>
<?php
if (file_exists($_SERVER['DOCUMENT_ROOT']."/images/mc/".$model->id."/mc_small_".$model->id.".jpg"))
	{
	$randnum = rand();
	echo "<img id='img_smin' src='/images/mc/".$model->id."/mc_small_".$model->id.".jpg?d=".$randnum."'>";
	}
else echo "<img id='img_smin' src='/src/img/opacity.png'>";
?>
<form enctype="multipart/form-data" action="/ajax/uploader/" method="POST" id="mainForm">
   <input id="uploadImage" type="file" accept="image/*" name="image"/>
   <input name="idpage" id="idpage" type="hidden" value="<?php echo $model->id; ?>">
   <input name="typepage" id="typepage" type="hidden" value="3">
   <input id="button" type="submit" value="Upload">
</form>
<div id="results"></div>
<img style="display:none" id="loader" src="/src/img/loader.gif" alt="Loading...." title="Loading...." />
<script>
  $("#mainForm").submit(function (event) {
	$("#results").empty();
    event.preventDefault();
    var data = new FormData($('#mainForm')[0]);
    data.append('idpage',$("#idpage").val());
    data.append('typepage',$("#typepage").val());
    $.ajax({
      type: "POST",
      url: "/ajax/uploader/",
      data: data,
      contentType: false,
      processData: false,
      cache: false,
      beforeSend: function() {
        $('#loader').show();
      }
    }).done(function (html) {
    	$("#results").empty();
        $("#results").append(html);
        $('#loader').hide();
        $('#mainForm')[0].reset();
      });
  });
</script>




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
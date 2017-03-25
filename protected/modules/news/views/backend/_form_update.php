<?php
/* @var $this BackendController */
/* @var $model News */
/* @var $form CActiveForm */
?>

<div class="form">

<p><b>1) Изображение превью на Главной (195x%):</b></p>
<?php
if (file_exists($_SERVER['DOCUMENT_ROOT']."/images/news/".$model->id."/news_smin_".$model->id.".jpg"))
	{
	$randnum = rand();
	echo "<img id='img_smin' src='/images/news/".$model->id."/news_smin_".$model->id.".jpg?d=".$randnum."'>";
	}
else echo "<img id='img_smin' src='/src/img/opacity.png'>";
?>
<form enctype="multipart/form-data" action="/ajax/uploader/" method="POST" id="mainForm">
   <input id="uploadImage" type="file" accept="image/*" name="image"/>
   <input name="idpage" id="idpage" type="hidden" value="<?php echo $model->id; ?>">
   <input name="typepage" id="typepage" type="hidden" value="1">
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



<p><b>2) Изображение превью на странице Новости (100x100):</b></p>
<?php
if (file_exists($_SERVER['DOCUMENT_ROOT']."/images/news/".$model->id."/news_small_".$model->id.".jpg"))
	{
	$randnum = rand();
	echo "<img id='img_smin2' src='/images/news/".$model->id."/news_small_".$model->id.".jpg?d=".$randnum."'>";
	}
else echo "<img id='img_smin2' src='/src/img/opacity.png'>";
?>
<form enctype="multipart/form-data" action="/ajax/uploader/" method="POST" id="mainForm2">
   <input id="uploadImage" type="file" accept="image/*" name="image"/>
   <input name="idpage" id="idpage2" type="hidden" value="<?php echo $model->id; ?>">
   <input name="typepage" id="typepage2" type="hidden" value="2">
   <input id="button" type="submit" value="Upload">
</form>
<div id="results2"></div>
<img style="display:none" id="loader2" src="/src/img/loader.gif" alt="Loading...." title="Loading...." />
<script>
  $("#mainForm2").submit(function (event) {
	$("#results2").empty();
    event.preventDefault();
    var data = new FormData($('#mainForm2')[0]);
    data.append('idpage',$("#idpage2").val());
    data.append('typepage',$("#typepage2").val());
    $.ajax({
      type: "POST",
      url: "/ajax/uploader/",
      data: data,
      contentType: false,
      processData: false,
      cache: false,
      beforeSend: function() {
        $('#loader2').show();
      }
    }).done(function (html) {
    	$("#results2").empty();
        $("#results2").append(html);
        $('#loader2').hide();
        $('#mainForm2')[0].reset();
      });
  });
</script>


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
	
	<?php
		$model->time = date('Y-m-d H:i:s', $model->time);
		if ($model->timeend != 0) $model->timeend = date('Y-m-d H:i:s', $model->timeend);
	?>
	
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
		<?php echo "<br /><label>Дата (формат Год-месяц-день ч:м:с)</label>"; ?>
		<?php echo $form->textField($model,'time',array('style' => 'width:200px;', 'size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'time'); ?>
	</div>
	
	<div class="rowold">
		<?php echo "<br />Дата отмены показа (формат Год-месяц-день ч:м:с); По умолчанию:0; Пример:2014-07-25 14:28:02"; ?>
		<?php echo $form->textField($model,'timeend',array('style' => 'width:200px;', 'size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'timeend'); ?>
	</div>

	<div class="rowold buttons">
		<br />
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
/**********************************************************************************************
 *                            CMS Open Business Card
 *                              -----------------
 *	version				:	1.3.0
 *	copyright			:	(c) 2014 Monoray
 *	website				:	http://www.monoray.ru/
 *	contact us			:	http://www.monoray.ru/contact
 *
 * This file is part of CMS Open Business Card
 *
 * Open Business Card is free software. This work is licensed under a GNU GPL.
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * Open Business Card is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * Without even the implied warranty of  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 ***********************************************************************************************/

class fieldEditor extends CWidget {
	public $modelName;
	public $model;
	public $field;
	public $type = 'text-editor';

	public function run() {
		$this->modelName = get_class($this->model);
		$fieldId = 'id_' . $this->modelName . $this->field;
		
		$id = 0;
		if (isset($_GET['id'])) $id = $_GET['id'];
		
		switch ($this->type) {
			case 'text-editor':
				$options = array();

				//if (Yii::app()->user->getState('isAdmin')) { // if admin - enable upload image
				if (Yii::app()->user->checkAccess('role_page')) {
					//$options['filebrowserUploadUrl'] = CHtml::normalizeUrl(array('/site/uploadimage?type=imageUpload'));
					$options['filebrowserUploadUrl'] = CHtml::normalizeUrl(array('/ajax/imageadd?type=imageUpload&id='.$id.'&fieldtxt='.$this->field));
					
					$options['allowedContent'] = true;
					
					$options['maxImageWidth'] = 700;
   	 				$options['maxImageHeight'] = 800;
				}

				echo $this->widget('application.extensions.ckeditor.CKEditor', array(
					'model' => $this->model,
					'attribute' => $this->field,
					'language' => '' . Yii::app()->language . '',
					'editorTemplate' => 'full', //advanced, full, basic 
					'skin' => 'kama',
					'toolbar' => array(
						array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike'),
						array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'),
						array('NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
						array('Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor'),
						array('Image', 'Link', 'Unlink', 'SpecialChar'),
					),
					'options' => $options,
					'htmlOptions' => array('id' => $fieldId)
				), true);
				
		/*		
echo $this->widget('application.extensions.ckeditor.CKEditor', array(
      'model'=>$this->model,
      'attribute'=>'html',
      'language'=>'ru',
      'editorTemplate'=>'full',
      'height'=>'500px'
));*/
				
				break;
		}
	}
}
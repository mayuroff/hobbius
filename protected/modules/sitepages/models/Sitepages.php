<?php

/**
 * This is the model class for table "{{sitepages}}".
 *
 * The followings are the available columns in table '{{sitepages}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $status
 * @property string $url_page
 * @property string $title_for_admin
 * @property string $title_short
 * @property string $keywords
 * @property string $description
 */
class Sitepages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sitepages}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('url_page, title_for_admin, title_short, content', 'required', 'on'=>'add, update'),
            array('parent_id, status, layout', 'numerical', 'integerOnly'=>true, 'on'=>'add, update'),
            array('url_page, title_for_admin, title_short, keywords, description', 'length', 'max'=>250, 'on'=>'add, update'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, parent_id, status, url_page, title_for_admin, title_short, keywords, description, layout, content', 'safe', 'on'=>'add, content, update'), 
			array('url_page', 'urlPageBase', 'on'=>'add'),
		);
	}
	
	public function urlPageBase($attribute,$params)
	{
		$sql = "SELECT count(*) FROM {{sitepages}} WHERE ((status=0) and (url_page='".$this->url_page."'));";
		$command=Yii::app()->db->createCommand($sql);
		$r=$command->queryScalar();
		if($r > 0) $this->addError('url_page','Url адрес страницы уже существует!');
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Родитель',
			'status' => 'Статус',
			'url_page' => 'Публичный URL',
			'title_for_admin' => 'Заголовок для "Хлебных крошек"',
			'title_short' => 'Title (meta)',
			'keywords' => 'Keywords (meta)',
			'description' => 'Description (meta)',
			'layout' => 'Шаблон №',
			'content' => 'Контент',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('url_page',$this->url_page,true);
		$criteria->compare('title_for_admin',$this->title_for_admin,true);
		$criteria->compare('title_short',$this->title_short,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('layout',$this->layout);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sitepages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

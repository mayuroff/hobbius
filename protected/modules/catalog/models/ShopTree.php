<?php

/**
 * This is the model class for table "shop_tree".
 *
 * The followings are the available columns in table 'shop_tree':
 * @property string $id
 * @property string $name
 * @property string $shop_tree_id
 * @property string $comment
 * @property string $picture_id
 * @property string $position
 */
class ShopTree extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'shop_tree';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('comment', 'required'),
			array('id, shop_tree_id, picture_id', 'length', 'max'=>20),
			array('name', 'length', 'max'=>250),
			array('position', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, shop_tree_id, comment, picture_id, position', 'safe', 'on'=>'search'),
		);
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
			'name' => 'Name',
			'shop_tree_id' => 'Shop Tree',
			'comment' => 'Comment',
			'picture_id' => 'Picture',
			'position' => 'Position',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('shop_tree_id',$this->shop_tree_id,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('picture_id',$this->picture_id,true);
		$criteria->compare('position',$this->position,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopTree the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

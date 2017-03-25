<?php
class WheretobuyWidget extends CWidget
{
    public $tpl='default';
	public $params = array('id'=>0);

    public function run()
    {
        /*$connection=Yii::app()->db;
		$sql = "select * from topdelivery ORDER BY city";
		$command=$connection->createCommand($sql);
		$rows=$command->queryAll();*/

        $this->render('Wheretobuy/' . $this->tpl, array());
    }
}
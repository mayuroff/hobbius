<?php
class BoxberryCourierWidget extends CWidget
{
    public $tpl='default';
	public $params = array('id'=>0);

    public function run()
    {
        $connection=Yii::app()->db;
		$sql = "select * from boxberry GROUP BY city";
		$command=$connection->createCommand($sql);
		$rows=$command->queryAll();

        $this->render('BoxberryCourier/' . $this->tpl, array('rows'=>$rows));
    }
}
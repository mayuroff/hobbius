<?php
class LastPostsWidget extends CWidget
{
    public $tpl='default';
	public $params = array('limit'=>1);

    public function run()
    {
    	$datenow = strtotime("now");
        $connection=Yii::app()->db;
		$sql = "SELECT * FROM {{news}} where (timeend=0 OR timeend>".$datenow.") ORDER BY time DESC LIMIT ".$this->params['limit'];
		$command=$connection->createCommand($sql);
		$rows=$command->queryAll();
		//$rows = 2;
		
        $this->render('LastPosts/' . $this->tpl, array('rows'=>$rows, 'limit'=>$this->params['limit']));
    }
}
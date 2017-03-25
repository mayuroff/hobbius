<?php
class McLastPostsWidget extends CWidget
{
    public $tpl='default';
	public $params = array('limit'=>1);

    public function run()
    {
    	$datenow = strtotime("now");
        $connection=Yii::app()->db;
		$sql = "SELECT * FROM {{masterclasses}} ORDER BY time DESC LIMIT ".$this->params['limit'];
		$command=$connection->createCommand($sql);
		$rows=$command->queryAll();
		//$rows = 2;
		
        $this->render('McLastPosts/' . $this->tpl, array('rows'=>$rows, 'limit'=>$this->params['limit']));
    }
}
<?php
class ShowCatWidget extends CWidget
{
    public $tpl='default';
	public $params = array('limit'=>1,'page_str'=>0,'id_next'=>0);

    public function run()
    {
    	$connection=Yii::app()->db;
    	
    	$sql = "SELECT * FROM Menu ORDER BY PosName;";
		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();

        $this->render('ShowCat/' . $this->tpl, array('rows'=>$rows));
    }
}
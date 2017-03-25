<?php
class FilterWidget extends CWidget
{
    public $tpl='default';
	public $params = array('limit'=>1,'page_str'=>0,'id_next'=>0);

    public function run()
    {
    	
    	
    	//$connection=Yii::app()->db;
    	
    	//$sql = "SELECT * FROM {{tree}} ORDER BY treename;";
		//$command = $connection->createCommand($sql);
		//$rows = $command->queryAll();
		
    	$rows = 0;

        $this->render('Filter/' . $this->tpl, array('rows'=>$rows));
    }
}
<?php
class SkoroWidget extends CWidget
{
    public $tpl='default';
	public $params = array('limit'=>6);

    public function run()
    {
    	$page_new = 0;
    	if (!isset($this->params['limit'])) {$this->params['limit'] = 1000; $page_new = 1;}
    	$connection=Yii::app()->db;
		$sql = "SELECT * FROM Goods WHERE Wait = 1 GROUP BY GoodID LIMIT ".$this->params['limit'];

		$command=$connection->createCommand($sql);
		$rows=$command->queryAll();

        $this->render('Novinki/' . $this->tpl, array('rows'=>$rows, 'limit'=>$this->params['limit'], 'page_new'=>$page_new, 'skoro'=>1));
    }
}
<?php
class NovinkiWidget extends CWidget
{
    public $tpl='default';
	public $params = array('limit'=>6);

    public function run()
    {
    	$page_new = 0;
    	if (!isset($this->params['limit'])) {$this->params['limit'] = 1000; $page_new = 1;}
    	$connection=Yii::app()->db;
		//$sql = "SELECT * FROM Goods LIMIT ".$this->params['limit'];
		
		//4месяца
		$year=date("Y");
		$month=date("n")-4;
		if($month<=0)
		{
			$year=$year-1;
			$month=12+$month;
		}
		if(strlen($month)==1) $month="0".$month;
		$maxdate=$year."-".$month."-".date("d G:i:s");
		
		$sql = "SELECT * FROM Goods LEFT JOIN Details ON (Goods.GoodID = Details.GoodID) WHERE (Goods.Wait = 0 and Details.detail_adddata > '".$maxdate."') GROUP BY Goods.GoodID ORDER BY Details.detail_adddata DESC LIMIT ".$this->params['limit'];
		
		$command=$connection->createCommand($sql);
		$rows=$command->queryAll();

        $this->render('Novinki/' . $this->tpl, array('rows'=>$rows, 'limit'=>$this->params['limit'], 'page_new'=>$page_new, 'skoro'=>0));
    }
}
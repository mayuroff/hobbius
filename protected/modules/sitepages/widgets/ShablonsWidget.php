<?php
class ShablonsWidget extends CWidget
{
    public $tpl='default';
	public $params = array('id_layout'=>0);

    public function run()
    {
        $connection=Yii::app()->db;
		$sql = "SELECT * FROM {{layouts}} WHERE id = ".$this->params['id_layout'];
		$command=$connection->createCommand($sql);
		$rows=$command->queryAll();

        $this->render('Shablons/' . $this->tpl, array('rows'=>$rows));
    }
}
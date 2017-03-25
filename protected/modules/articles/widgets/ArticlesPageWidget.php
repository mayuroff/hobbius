<?php
class ArticlesPageWidget extends CWidget
{
    public $tpl='default';
	public $params = array('limit'=>1,'page_str'=>0,'id_next'=>0);

    public function run()
    {
    	
    	$id_next = $this->params['id_next'];
    	
    	if ($id_next == 0)
    	{
	    	$total = 10; //количество новостей на странице
	
	    	$connection=Yii::app()->db;
	    	
			$sql = "SELECT count(*) FROM {{articles}};";
			$command=$connection->createCommand($sql);
			$count=$command->queryScalar();
			
			$page_str = $this->params['page_str'];
			
			if ($page_str == 1) throw new CHttpException(404,'The requested page does not exist.');
			elseif ($page_str == 2) throw new CHttpException(404,'The requested page does not exist.');
			elseif ($page_str != 0) $page_str = $page_str - 2;
			
			if ($count == $total) $num = 1;
			elseif ($count % $total != 0) {$num = floor($count / $total); $num++;}
			else $num = floor($count / $total);
			
			$first = 0;
			$first = $total*$page_str;
			$sql = "SELECT * FROM {{articles}} ORDER BY time DESC LIMIT ".$first.",".$total;
			$command=$connection->createCommand($sql);
			$rows=$command->queryAll();
			
			if (sizeof($rows) == 0) throw new CHttpException(404,'The requested page does not exist.');
    	}
    	else {
    		$connection=Yii::app()->db;
    		$sql = "SELECT * FROM {{articles}} where id=".$id_next;
			$command=$connection->createCommand($sql);
			$rows=$command->queryAll();
			if (sizeof($rows) == 0) throw new CHttpException(404,'The requested page does not exist.');
			
    		
    		//echo $breadcrumbs->breadcrumbs[]="111";
    		$count = 0;
    		$num = 0;
    		$page_str = 0;
    		
    		//$rows = 0;
    		
    	}
		
        $this->render('ArticlesPage/' . $this->tpl, array('rows'=>$rows, 'count'=>$count, 'page_num'=>$num, 'page_now'=>$page_str, 'id_next'=>$id_next));
    }
}
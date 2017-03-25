<?php

if (isset($id)) 
{
	function levelok($father)
		{
			echo("<ul>");
			//$r=mysql_query("select * from shop_tree where shop_tree_id=$father");
			//while($s=mysql_fetch_array($r))
			$sql = "select * from shop_tree where shop_tree_id=".$father;
			$command=Yii::app()->db->createCommand($sql);
			$r=$command->query();
			foreach($r as $s)
			{
				$title=iconv("windows-1251", "utf-8", urldecode($s['name']));
				echo("<li><a href=\"/catalog/".$s['id']."/\">".$title."</a>");			
				//$r2=mysql_query("select count(*) from shop_tree where shop_tree_id=".$s['id']);
				//$s2=mysql_fetch_array($r2);
				$sql = "select count(*) from shop_tree where shop_tree_id=".$s['id'];
				$command=Yii::app()->db->createCommand($sql);
				$s2=$command->queryScalar();
				if($s2[0]>0) levelok($s['id']); 
				echo("</li>");
			}
			echo("</ul>");
		}
		
		
	if ($id == 0)
	{
		echo("<ul>");
		//$z=1;
		//$r=mysql_query("select * from shop_tree where shop_tree_id=0");
		//while($s=mysql_fetch_array($r))
		
		$sql = "select * from shop_tree where shop_tree_id=0";
		$command=Yii::app()->db->createCommand($sql);
		$r=$command->query();
		foreach($r as $s)
		{
			$title=iconv("windows-1251", "utf-8", urldecode($s['name']));
			if ( (strcmp($title, "Каталоги") !== 0) && (strcmp($title, "Подарочные карты") !== 0))
			{
				if (strcmp($title, "Вышивание") === 0) $z = 1;
				if (strcmp($title, "Вязание") === 0) $z = 2;
				if (strcmp($title, "Бисероплетение, макраме") === 0) $z = 3;
				if (strcmp($title, "Шитье") === 0) $z = 4;
				if (strcmp($title, "Печатная продукция") === 0) $z = 5;
				if (strcmp($title, "Разное") === 0) $z = 6;
				if (strcmp($title, "Ткани") === 0) $z = 7;
				if (strcmp($title, "Рукоделие") === 0) $z = 8;
			
				echo("<li><a href=\"/sitemap/".$z."/\">$title</a>");
				echo("</li>");
			}
			//$z++;
		}
		echo("</ul>");
	}
	elseif ( ($id > 0) && ($id < 9) )
	{
		$shop_tree_id = 0;
		if ($id == 1) $shop_tree_id = 1436906062;
		if ($id == 2) $shop_tree_id = 1444732062;
		if ($id == 3) $shop_tree_id = 1452786462;
		if ($id == 4) $shop_tree_id = 1454718762;
		if ($id == 5) $shop_tree_id = 1474576062;
		if ($id == 6) $shop_tree_id = 1474596662;
		if ($id == 7) $shop_tree_id = 8433465762;
		if ($id == 8) $shop_tree_id = 2664666262;
		
		if ($shop_tree_id != 0)
		{
			echo("<ul>");
			//$r=mysql_query("select * from shop_tree where shop_tree_id=1436906062");
			//while($s=mysql_fetch_array($r))
			$sql = "select * from shop_tree where shop_tree_id=".$shop_tree_id;
			$command=Yii::app()->db->createCommand($sql);
			$r=$command->query();
			foreach($r as $s)
			{
				$title=iconv("windows-1251", "utf-8", urldecode($s['name']));
				echo("<li><a href=\"/catalog/".$s['id']."/\">".$title."</a>");
				levelok($s['id']);
				echo("</li>");
			}
			echo("</ul>");
		}
	}
	else 
	{
		throw new CHttpException(404,'The requested page does not exist.');
		exit();
	}

}

?>
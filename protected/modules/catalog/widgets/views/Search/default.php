<?php if (isset($s)): ?>
	
	
	<?php 
	$where_know = "";
	$p12 = "";
	
	if (isset($_POST['s'])) {
		$_POST['s'] = trim($_POST['s']);
		if (($_POST['s'] == "Введите название товара или его артикул...")||($_POST['s'] == "Введите")) $_POST['s'] = ""; $_SESSION['search_cat'] = $_POST['s']; $s = $_POST['s'];
	}
	elseif (isset($_GET['s'])) {
		$_GET['s'] = trim($_GET['s']);
		if (($_GET['s'] == "Введите название товара или его артикул...")||($_GET['s'] == "Введите")) $_GET['s'] = ""; $_SESSION['search_cat'] = $_GET['s']; $s = $_GET['s'];
	}
	else $s = "";
	
	$s = iconv("utf-8", "windows-1251//TRANSLIT", $s);
	$s = iconv("windows-1251//TRANSLIT", "utf-8", $s);
	
	//$s = real_escape_string($s);
	
	$s = str_replace("%", "", $s);
	
	//echo $s; echo "<br />";
	if (isset($_POST['pr1'])) {$_SESSION['search_pr1'] = $_POST['pr1']; $pr1 = str_replace(" ", "", $_POST['pr1']);}  else $pr1 = "";
	//echo $pr1; echo "<br />";
	if (isset($_POST['pr2'])) {$_SESSION['search_pr2'] = $_POST['pr2']; $pr2 = str_replace(" ", "", $_POST['pr2']); if (strlen($pr1) == 0) $pr1 = "0"; if (strlen($pr2) == 0) $pr2 = "10000"; $p12 = "(Price >= ".$pr1.") and (Price <= ".$pr2.")";}  else $pr2 = "";
	//echo $pr2; echo "<br />";
	if (isset($_POST['forwhom1'])) {$_SESSION['search_forwhom1'] = $_POST['forwhom1']; $forwhom1 = $_POST['forwhom1'];}  else {$_SESSION['search_forwhom1'] = 0; $forwhom1 = "";}
	//echo $forwhom1; echo "<br />";
	if (isset($_POST['forwhom2'])) {$_SESSION['search_forwhom2'] = $_POST['forwhom2']; $forwhom2 = $_POST['forwhom2'];}  else {$_SESSION['search_forwhom2'] = 0; $forwhom2 = "";}
	//echo $forwhom2; echo "<br />";
	if (isset($_POST['theme'])) {$_SESSION['search_theme'] = $_POST['theme']; $theme = $_POST['theme'];}  else $theme = "";
	//echo $theme; echo "<br />";
	if (isset($_POST['know'])) {$_SESSION['search_know'] = $_POST['know']; $know = $_POST['know'];}  else $know = "";
	//echo $know; echo "<br />";
	if (isset($_POST['complex1'])) {$_SESSION['search_complex1'] = $_POST['complex1']; $complex1 = $_POST['complex1'];}  else {$_SESSION['search_complex1'] = 0; $complex1 = "";}
	//echo $complex1; echo "<br />";
	if (isset($_POST['complex2'])) {$_SESSION['search_complex2'] = $_POST['complex2']; $complex2 = $_POST['complex2'];}  else {$_SESSION['search_complex2'] = 0; $complex2 = "";}
	//echo $complex2; echo "<br />";
	if (isset($_POST['complex3'])) {$_SESSION['search_complex3'] = $_POST['complex3']; $complex3 = $_POST['complex3'];}  else {$_SESSION['search_complex3'] = 0; $complex3 = "";}
	//echo $complex3; echo "<br />";

	
	function imga($filename,$pref)
	{
		$a=md5($filename);
		$path='http://images.firma-gamma.ru/150x150'.$pref.'/'.$a[0].'/'.$a[1].'/'.$filename;
		return $path;
	}
	function imga2($filename,$pref)
	{
		$a=md5($filename);
		$path='http://images.firma-gamma.ru/150x150'.$pref.'/'.$a[0].'/'.$a[1].'/'.$filename;
		return $path;
	}
	
	
	//поиск по наполнителю
	if ($know == 2) $know = "Нет";
	if ($know == 1) $know = "Есть";
	//echo $know;
	if (strlen($know) > 0)
	{
		$where_know = "";
		$connection=Yii::app()->db;
		$sql = "SELECT * FROM Details LEFT JOIN PropertyD ON PropertyD.DetailID = Details.DetailID where (PropertyID = 22562705412) and (Value LIKE '%".$know."%')";
		$command=$connection->createCommand($sql);
		$s0=$command->queryAll();
		$k = 0;
		foreach($s0 as $row0)
		{
			
			if (sizeof($s0) == 1) $where_know .= " (GoodID = ".$row0['GoodID'].")";
			elseif (sizeof($s0) > 1)
			{
				if ($k == 0) $where_know .= " (GoodID = ".$row0['GoodID'].")";
				$k++;
				$where_know .= " or (GoodID = ".$row0['GoodID'].")";
			
			}
		}
		$where_know;
	}
	
	//поиск по артиклу
	$where0 = "";
	$connection=Yii::app()->db;
	$sql = "SELECT * FROM Property where (PropertyID = 1) and (Value LIKE '%".$s."%')";
	$command=$connection->createCommand($sql);
	$s0=$command->queryAll();
	foreach($s0 as $row0)
	{
		$k = 0;
		if (sizeof($s0) == 1) $where0 .= " or (GoodID = ".$row0['GoodID'].")";
		elseif (sizeof($s0) > 1)
		{
			if ($k == 1) $where0 .= " (GoodID = ".$row0['GoodID'].")";
			$k++;
			$where0 .= " or (GoodID = ".$row0['GoodID'].")";
		
		}
	}

	//поиск по названию и цене + артиклу
	$where = "where Wait>=0 ";
	if (strlen($p12) > 0)
	{
		$where .= "and ".$p12;
		if (strlen($s) > 0)
		{
			if (strlen($where_know) > 0)
				$where .= " and ((GoodName LIKE '%".$s."%') ".$where0.") and (".$where_know.")";
			else 
				$where .= " and ((GoodName LIKE '%".$s."%') ".$where0.") ";
		}
		else {
			if (strlen($where_know) > 0)
				$where .= " and (".$where_know.")";
		}
	}
	else {
		if (strlen($s) > 0)
		{
			$where .= "and ((GoodName LIKE '%".$s."%') ".$where0.")";
		}
	}
	
	$connection=Yii::app()->db;
	$sql = "SELECT * FROM Goods ".$where." GROUP BY Goods.GoodID"; echo "<br />";
	$command=$connection->createCommand($sql);
	$s=$command->queryAll();
	if (sizeof($s) > 0)
	{
		echo '<h2 style="color: #fca000;font-size: 141%; margin-bottom: 14px;">Найдено наборов: '.sizeof($s).'шт.</h2>';
		$i = 0;
		foreach($s as $row)
		{
			//echo $r['GoodName']; echo "<br />";
			
			
			$i++;

			//if(file_exists(imga2("g".$row['GoodID'].'u.jpg',""))) 
			$img1 = "<img style=\"height:150px;\" src=\"".imga("g".$row['GoodID'].'u.jpg',"")."\">";
			//elseif(file_exists(imga2("g".$row['GoodID'].'.jpg',""))) $img1 = "<img style=\"height:150px;\" src=\"".imga("g".$row['GoodID'].'.jpg',"")."\">";
			//else $img1 = "no foto<img style=\"height:150px;\" src=\"/src/img/opacity.png\">";
			/*
			$sql='SELECT * FROM Property,PropertyItem WHERE (GoodID='.$row['GoodID'].') and (Property.PropertyID = PropertyItem.PropertyID) and ((PropertyItem.PropertyID = 1) or (PropertyItem.PropertyID = 22))';
			$command=Yii::app()->db->createCommand($sql);
			$s2=$command->queryAll();
			$property = "";
			if (count($s2) > 0)
			{
				foreach($s2 as $row2)
					$property .= '<b>'.$row2['PropertyName'].':</b> '.$row2['Value'].'<br />';
			}
			*/
			$sql = 'SELECT * FROM Property,PropertyItem WHERE (GoodID='.$row['GoodID'].') and (Property.PropertyID = PropertyItem.PropertyID) and ((PropertyItem.PropertyID = 1) or (PropertyItem.PropertyID = 22) or (PropertyItem.PropertyID = 22562429262))';
			$command=Yii::app()->db->createCommand($sql);
			$s2=$command->queryAll();
			$property = "";
			$property_art = "";
			if (count($s2) > 0)
			{
				foreach($s2 as $row2)
				{
					if ($row2['PropertyID'] != 1)$property .= '<b>'.$row2['PropertyName'].':</b> '.$row2['Value'].'<br />';
					if ($row2['PropertyID'] == 1) $property_art .= $row2['Value'];
				}
			}
			
			$sql = 'SELECT * FROM Details LEFT JOIN PropertyD ON PropertyD.DetailID = Details.DetailID where (PropertyID = 22562429262) and (Details.GoodID='.$row['GoodID'].')';
			$command=Yii::app()->db->createCommand($sql);
			$s2=$command->queryAll();
			if (count($s2) > 0)
			{
				foreach($s2 as $row2)
				{
					$property .= '<b>Высота изделия (см):</b> '.$row2['Value'].'<br />';
				}
			}
			
			$vnalich = "Товара нет";
			$ball = '';
			$sql='SELECT * FROM Details WHERE (GoodID='.$row['GoodID'].')';
			$command=Yii::app()->db->createCommand($sql);
			$s2=$command->queryAll();
			if (count($s2) > 0)
			{
				foreach($s2 as $row2)
				{
					$vnalich_flag = 0;
					if (($row2['Quantity'] > 0) || (($row2['Quantity'] == 0) && ($row2['Quantityopt'] == 1)) ) {
						if ( ($row2['Quantity'] == 0) && ($row2['Quantityopt'] == 1) ) $vnalich = '<span style="color:#4638E2">Под заказ</span>';
						else $vnalich = "В наличии";
						$vnalich_flag = 1;
						
						
						
						
						$sql = "select * from {{rating_total}} where id_nabor=".$row['GoodID']." limit 1;";
						$command=Yii::app()->db->createCommand($sql);
						$r3=$command->query();
						if (sizeof($r3) != 0) {
							foreach($r3 as $s3)	{
								$ocenka = round($s3['itogo'],2);
								if ($ocenka>5) $ocenka='5+';
								$ball = '<p class="novinky-rating">Средняя оценка: <b>'.$ocenka.'</b></p>';
							}
						}
						
						
						
						
					}
					else $vnalich = '<span style="color:#4638E2">Скоро в продаже</span>';
				}
			}
			
			echo '
			<div class="novinky_list_el">
				<!--<p class="novinky-hit"><img alt="" src="/src/img/hit.gif"></p>-->';
			
				$sql = "SELECT * FROM {{akciya}} where `GoodID` = ".$row['GoodID'].";";
				$command=Yii::app()->db->createCommand($sql);
				$r=$command->query();
				
				if (sizeof($r) == 0) {
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
					
					$sql = "SELECT * FROM Details where `GoodID` = ".$row['GoodID']." and Details.detail_adddata < '".$maxdate."'";
					$command=Yii::app()->db->createCommand($sql);
					$r=$command->query();
				}
		
				if (sizeof($r) == 0) echo '<p class="novinky-hit"><a href="/action/" target="_blank"><img alt="" src="/src/img/action.png"></a></p>';
				else echo '<p class="novinky-hit">&nbsp;</p>';
				
				//if ($row['Price'] == 0) $row['Price'] = "";
				
				echo '
				<p class="novinky-img">'.$img1.'</p>
				<div class="novinky-line"></div>
				<p class="novinky-title"><a href="/catalog/good_'.$row['GoodID'].'/">'.$property_art.' '.$row['GoodName'].'</a></p>';
				if ($row['Price'] != 0) echo '<p class="novinky-price"><b>'.$row['Price'].' </b>руб.</p>';
				echo '<p class="novinky-exist">'.$vnalich.'</p>
				'.$ball.'
				<div class="novinky_list_el_onhover">
					<!--<p class="novinky-hit"><img alt="" src="/src/img/hit.gif"></p>-->';
					
					if (sizeof($r) == 0) echo '<p class="novinky-hit"><a href="/action/" target="_blank"><img alt="" src="/src/img/action.png"></a></p>';
					else echo '<p class="novinky-hit">&nbsp;</p>';
					
					echo '
					<p class="novinky-img"><a href="/catalog/good_'.$row['GoodID'].'/" target="_blank">'.$img1.'</a></p>
					<div class="novinky-line"></div>
					<p class="novinky-title"><a href="/catalog/good_'.$row['GoodID'].'/">'.$property_art.' '.$row['GoodName'].'</a></p>';
					if ($row['Price'] != 0) echo '<p class="novinky-price"><b>'.$row['Price'].' </b>руб.</p>';
					echo '<p class="novinky-exist">'.$vnalich.'</p>
					'.$ball.'
					<div class="novinky-line novinky-margin"></div>
					<div class="novinky-size">
					'.$property.'
					</div>';
					
					if ($vnalich_flag == 1) echo '<img alt="" style="cursor:pointer;" onclick="add2cart(this,'.$row['GoodID'].',1); return false;" src="/src/img/tobox.gif">&nbsp;&nbsp;';
					
					echo '<a href="/catalog/good_'.$row['GoodID'].'/"><img alt="" src="/src/img/toviel.gif"></a>
				</div>
			</div>';
			if ($i%3 == 0) echo '<div class="both"></div>';
			
			
			
		}
	}
	else echo '<h2 style="color: #fca000;font-size: 141%; /*font-weight: bold;*/ margin-bottom: 14px;">Ничего не найдено!</h2>';
	
	
	?>
			
	
<?php endif; ?>


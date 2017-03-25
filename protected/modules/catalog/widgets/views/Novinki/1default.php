<?php if(isset($rows) && $rows != array()): ?>
	<?php  
	
		function imga($filename,$pref)
		{
			$a=md5($filename);
			$path='/images/gamma'.$pref.'/'.$a[0].'/'.$a[1].'/'.$filename;
			return $path;
		}
		function imga2($filename,$pref)
		{
			$a=md5($filename);
			$path='./images/gamma'.$pref.'/'.$a[0].'/'.$a[1].'/'.$filename;
			return $path;
		}
	
		$i = 0;
		
		if ($page_new == 0) echo '<div class="novinky">
			<div class="navi">
				<div class="navi-select">Новинки</div>
				<!--<div class="">Хит продаж</div>
				<div class="">Промоакции</div>-->
			</div>';
		else echo '<div class="main_text"><h2>Новинки</h2></div>';
		
		foreach ($rows as $row):
		
			$i++;

			if(file_exists(imga2("g".$row['GoodID'].'u.jpg',""))) $img1 = "<img style=\"height:150px;\" src=\"".imga("g".$row['GoodID'].'u.jpg',"")."\">";
			elseif(file_exists(imga2("g".$row['GoodID'].'.jpg',""))) $img1 = "<img style=\"height:150px;\" src=\"".imga("g".$row['GoodID'].'.jpg',"")."\">";
			else $img1 = "no foto<img style=\"height:150px;\" src=\"/src/img/opacity.png\">";
			/*
			if(file_exists(imga2("g".$row['GoodID'].'.jpg',""))) $img1 = "<img style=\"height:150px;\" src=\"".imga("g".$row['GoodID'].'.jpg',"t")."\">";
			elseif(file_exists(imga2("g".$row['GoodID'].'u.jpg',""))) $img1 = "<img style=\"height:150px;\" src=\"".imga("g".$row['GoodID'].'u.jpg',"t")."\">";
			else $img1 = "no foto<img style=\"height:150px;\" src=\"/src/img/opacity.png\">";
****/
			
			//$sql='SELECT * FROM Property,PropertyItem WHERE (GoodID='.$row['GoodID'].') and (Property.PropertyID = PropertyItem.PropertyID) and ((PropertyItem.PropertyID = 1) or (PropertyItem.PropertyID = 22) or (PropertyItem.PropertyID = 22562429262))';
			
			
			$sql='SELECT * FROM Property,PropertyItem WHERE (GoodID='.$row['GoodID'].') and (Property.PropertyID = PropertyItem.PropertyID) and ((PropertyItem.PropertyID = 1) or (PropertyItem.PropertyID = 22) or (PropertyItem.PropertyID = 22562429262))';
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
			$vnalich_flag = 0;
			$ball = '';
			$sql='SELECT * FROM Details WHERE (GoodID='.$row['GoodID'].')';
			$command=Yii::app()->db->createCommand($sql);
			$s2=$command->queryAll();
			if (count($s2) > 0)
			{
				foreach($s2 as $row2)
				{
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
					else $vnalich = '<span style="color:#9A9E94">Товара нет</span>';
				}
			}
			
			echo '
			<div class="novinky_list_el">
				<!--<p class="novinky-hit"><img alt="" src="/src/img/hit.gif"></p>-->';
			
				$sql = "SELECT * FROM {{akciya}} where `GoodID` = ".$row['GoodID'].";";
				$command=Yii::app()->db->createCommand($sql);
				$r=$command->query();
		
				if (sizeof($r) == 0) echo '<p class="novinky-hit"><a href="/action/" target="_blank"><img alt="" src="/src/img/action.png"></a></p>';
				else echo '<p class="novinky-hit">&nbsp;</p>';
				
				echo '
				<p class="novinky-img"><a href="/catalog/good_'.$row['GoodID'].'/">'.$img1.'</a></p>
				<div class="novinky-line"></div>
				<p class="novinky-title"><a href="/catalog/good_'.$row['GoodID'].'/">'.$property_art.' '.$row['GoodName'].'</a></p>
				<p class="novinky-price"><b>'.$row['Price'].' </b>руб.</p>
				<p class="novinky-exist">'.$vnalich.'</p>
				'.$ball.'
				<div class="novinky_list_el_onhover">
					<!--<p class="novinky-hit"><img alt="" src="/src/img/hit.gif"></p>-->';
					
					if (sizeof($r) == 0) echo '<p class="novinky-hit"><a href="/action/" target="_blank"><img alt="" src="/src/img/action.png"></a></p>';
					else echo '<p class="novinky-hit">&nbsp;</p>';
					
					echo '<p class="novinky-img"><a href="/catalog/good_'.$row['GoodID'].'/">'.$img1.'</a></p>
					<div class="novinky-line"></div>
					<p class="novinky-title"><a href="/catalog/good_'.$row['GoodID'].'/">'.$property_art.' '.$row['GoodName'].'</a></p>
					<p class="novinky-price"><b>'.$row['Price'].' </b>руб.</p>
					<p class="novinky-exist">'.$vnalich.'</p>
					'.$ball.'
					<div class="novinky-line novinky-margin"></div>
					<div class="novinky-size">
					'.$property.'
					</div>';
					
					if ($vnalich_flag == 1) echo '<img alt="" style="cursor:pointer;" onclick="add2cart(this,'.$row['GoodID'].',1); return false;" src="/src/img/tobox.gif">&nbsp;&nbsp;';
					
					echo '<a href="/catalog/good_'.$row['GoodID'].'/"><img alt="" src="/src/img/toviel.gif"></a>
				</div>
			</div>';
			if ($page_new == 0) {if ($i%3 == 0) echo '<div class="novinky-line"></div>';}
			else {if ($i%3 == 0) echo '<div class="both"></div>';}
			
			//$i++;
		endforeach;
		if ($page_new == 0) echo '<div class="both"></div>
		<div style="text-align: right; margin: 5px;"><a href="/novinki/"><img src="/src/img/all_new.png"></a></div>
		</div>';
	
	?>
<?php endif; ?>
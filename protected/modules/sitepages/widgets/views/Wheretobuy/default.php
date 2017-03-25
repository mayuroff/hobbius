<?php
{

	$i = 0;

	$sql = 'SELECT 1 AS num, t1.id_city, t1.name AS city FROM igla.leo_city AS t1 LEFT JOIN igla.leo_shops AS t2 ON (t1.id_city = t2.id_city) WHERE t2.newmag = 0 AND t2.franchayzi = 0 GROUP BY t1.id_city ';
	$sql .= ' UNION ';
	$sql .= 'SELECT 2 AS num, t1.id_city, t1.name AS city FROM leonardo.leo_city AS t1 LEFT JOIN leonardo.leo_shops AS t2 ON (t1.id_city = t2.id_city) WHERE t2.work = 1 GROUP BY t1.id_city ORDER BY city';
	$command = Yii::app()->db->createCommand($sql);
	$s = $command->queryAll();
	$city = '';
	$shop = '';
	$city_msk = '';
	$city_msk_id = 0;
	$city_spb_id = 0;
	
	$city_mas = array();
	$shop_mas = array();
	
	foreach($s as $rows) {
		$i++;
		$key = array_search($rows['city'], $city_mas);
		//if ($key === true) {
		if (in_array($rows['city'], $city_mas)){
			//город найден, уже добавлен в массив	
		} else {
			//город не найден, добавляем в массив
			$city_mas[] = $rows['city'];
			$shop_mas[] = "";
			$key = array_search($rows['city'], $city_mas);
			if ($rows['city'] == "Москва") $city_msk_id = $key;
			if ($rows['city'] == "Санкт-Петербург") $city_spb_id = $key;
		}
		
		if ($rows['num'] == 1)
			$sql = 'SELECT adress, phone FROM igla.leo_shops where (newmag = 0 AND franchayzi = 0 AND id_city = '.$rows['id_city'].');';
		else
			$sql = 'SELECT adress, phone FROM leonardo.leo_shops where (work = 1 AND id_city = '.$rows['id_city'].');';
		$command = Yii::app()->db->createCommand($sql);
		$s1 = $command->queryAll();
		
		foreach($s1 as $rows1) {
			if ($rows['num'] == 1)
				$shop_mas[$key] .= '<li>"Иголочка", '.$rows1['adress'].', '.$rows1['phone'].'</li>';
			else
				$shop_mas[$key] .= '<li>"Леонардо", '.$rows1['adress'].', '.$rows1['phone'].'</li>';
		}
	}
	//формируем список городов
	foreach ($city_mas as $key => $value) {
		if ($key == $city_spb_id) continue;
		elseif ($key == $city_msk_id) continue;
		else $city .= '<li><a onclick="$(\'.noshow\').hide(); oncl('.$key.');">'.$value.'</a></li>';
	}
	$city = '<li><a onclick="$(\'.noshow\').hide(); oncl('.$city_spb_id.');"><b>'.$city_mas[$city_spb_id].'</b></a></li>'.$city; //Москва
	$city = '<li><a onclick="$(\'.noshow\').hide(); oncl('.$city_msk_id.');"><b>'.$city_mas[$city_msk_id].'</b></a></li>'.$city; //Санкт-Петербург
	
	foreach ($shop_mas as $key => $value) {
		$shop .= '<div id="n'.$key.'" class="noshow"><h3>'.$city_mas[$key].'</h3><ul>';
		$shop .= $value;
		$shop .= '</ul></div>';
	}
	

	
	$sql = 'SELECT * FROM {{wheretobuy}} where optom = 1 GROUP BY city ORDER BY id';
	$command = Yii::app()->db->createCommand($sql);
	$s = $command->queryAll();
	$city_opt = '';
	$city_msk_opt = '';
	$shop_opt = '';
	foreach($s as $rows) {
		$i++;
		if ($rows['city'] == "Москва")
			$city_msk_opt .= '<li><a onclick="$(\'.noshow\').hide(); oncl('.$i.');"><b>'.$rows['city'].'</b></a></li>';
		elseif ($rows['city'] == "Санкт-Петербург")
			$city_msk_opt .= '<li><a onclick="$(\'.noshow\').hide(); oncl('.$i.');"><b>'.$rows['city'].'</b></a></li>';
		else 
			$city_opt .= '<li><a onclick="$(\'.noshow\').hide(); oncl('.$i.');">'.$rows['city'].'</a></li>';
		$sql = 'SELECT * FROM {{wheretobuy}} where optom = 1 and city LIKE "'.$rows['city'].'"';
		$command = Yii::app()->db->createCommand($sql);
		$s1 = $command->queryAll();
		$shop_opt .= '<div id="n'.$i.'" class="noshow optshop"><h3>'.$rows['city'].'</h3><ul>';
		foreach($s1 as $rows1) {
			$shop_opt .= '<li>'.$rows1['name'].' '.$rows1['adress'].' '.$rows1['phone'].'</li>';
		}
		$shop_opt .= '</ul></div>';
	}
	
	
	
	$addtxt = '
	
	<script>
	function oncl(a) {
		$(\'.noshow\').hide();
		var s = "#n"+a;
		$(s).show();
	}
	</script>
	
	<div class="wrapper wrapper_top">
		    	<div class="wheretobuy_page">
		                <h1>Где купить?</h1>
		                
		                <div id="map_canvas" style="width:100%; height:400px; margin: 0 auto;"></div>
		                <br />
		                
		                <div class="adresses-shops">
			                <div class="tab-block-country">
			                
			                	<!-- Nav tabs -->
			                	<ul id="tabChangeBuy" class="nav nav-tabs" role="tablist">
			                		<li class="active"><a href="#retail" data-toggle="tab" aria-expanded="true" onclick="$(\'.noshow\').hide(); oncl('.$city_msk_id.'); map_initialize(0);">В розницу</a></li>
			                		<li class=""><a href="#wholesale" data-toggle="tab" aria-expanded="false" onclick="$(\'.noshow\').hide(); $(\'.optshop\').show(); map_initialize(1);">Оптом</a></li>
			                	</ul>
			                	
			                	<!-- Tab panes -->
			                	<div class="tab-content">
			                	   <div class="tab-pane active" id="retail">
				                	   <ul>
				                	   '.$city_msk.'
				                	   '.$city.'
				                	   </ul>			               
			                	   </div>
			                	   <div class="tab-pane" id="wholesale">
			                	   		<ul>
			                	   		'.$city_msk_opt.'
			                	   		'.$city_opt.'
			                	   		</ul>
			                	   </div>
		                		</div>		
		                   </div>
		                   <!-- Adress View -->
			                <div class="adresses-view">
			                '.$shop.'
			                '.$shop_opt.'
			                </div>	
	
	                    </div>
	            </div>
	        </div>
	        
	        
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;key=AIzaSyB2njs2twcyKKfartxCCoxc-wBTSrxvFOE"></script>
<script type="text/javascript">

function map_initialize(flag) {
				var latlng = new google.maps.LatLng(55.754168, 37.621254);
				var settings = {
					zoom: 5,
					center: latlng,
					mapTypeControl: true,
					scrollwheel: false,
					mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
					navigationControl: true,
					navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
					mapTypeId: google.maps.MapTypeId.ROADMAP};
				map = new google.maps.Map(document.getElementById("map_canvas"), settings);
				
				var mnImage = new google.maps.MarkerImage(\'/src/img/point.png\',
					new google.maps.Size(24,31),
					new google.maps.Point(0,0),
					new google.maps.Point(12,31)
				);
				';
				
			//if (flag == 0) {	
				//Иголочка
				//$sql = 'SELECT * FROM {{wheretobuy}}';
				$sql = 'SELECT t1.id, t1.name, t1.adress, t1.phone, t1.roadmap, t2.name AS city_name FROM igla.leo_shops AS t1 LEFT JOIN igla.leo_city AS t2 ON (t1.id_city = t2.id_city) WHERE t1.newmag = 0 AND t1.franchayzi = 0';
				$command = Yii::app()->db->createCommand($sql);
				$s = $command->queryAll();
				$text_igla = '';
				$text_leo = '';
				$text_gamma = '';
				$text_mn_close = '';
				foreach($s as $rows) {
					$rows['name'] = addslashes($rows['name']);
					$rows['adress'] = addslashes($rows['adress']);
					$rows['phone'] = addslashes($rows['phone']);
					$rows['adress'] = str_replace(Array("'","\r","\n"),"",$rows['adress']);
					$text_igla .= 'var mn_Igla'.$rows['id'].';';
					
					$text_igla .= '
						contentString = \'<div id="cont_igla">\'+
						\'<div id="siteNotice_igla">\'+
						\'</div>\'+
						\'<h4>"Иголочка" '.$rows['name'].'</h4>\'+
						\'<div id="bodyContent">\'+
						\'<p>'.$rows['adress'].', '.$rows['phone'].'</p>\'+
						\'</div>\'+
						\'</div>\';
					';
					$text_igla .= '
						var info_mn_Igla'.$rows['id'].' = new google.maps.InfoWindow({
							content: contentString
						});
					';
					
					$text_igla .= '
					mn_Igla'.$rows['id'].' = new google.maps.Marker({
						position: new google.maps.LatLng('.$rows['roadmap'].'),
						map: map,
						icon: mnImage,
						animation: google.maps.Animation.DROP,
						title:"'.$rows['name'].'",
						zIndex: 3});
					';
					
					$text_mn_close .= '
						if (info_mn_Igla'.$rows['id'].') {eval(info_mn_Igla'.$rows['id'].').close();}
					';
					
					$text_igla .= '
					google.maps.event.addListener(mn_Igla'.$rows['id'].', \'click\', function() {
						mn_close();
						info_mn_Igla'.$rows['id'].'.open(map,mn_Igla'.$rows['id'].');
					});
					';
				}
				
				//Леонардо
				$sql = 'SELECT t1.id, t1.name, t1.adress, t1.phone, t1.roadmap, t2.name AS city_name FROM leonardo.leo_shops AS t1 LEFT JOIN leonardo.leo_city AS t2 ON (t1.id_city = t2.id_city) WHERE t1.work = 1';
				$command = Yii::app()->db->createCommand($sql);
				$s = $command->queryAll();
				foreach($s as $rows) {
					$rows['name'] = addslashes($rows['name']);
					$rows['adress'] = addslashes($rows['adress']);
					$rows['phone'] = addslashes($rows['phone']);
					$rows['adress'] = str_replace(Array("'","\r","\n"),"",$rows['adress']);
					$text_leo .= 'var mn_Leo'.$rows['id'].';';
					
					$text_leo .= '
						contentString = \'<div id="cont_igla">\'+
						\'<div id="siteNotice_igla">\'+
						\'</div>\'+
						\'<h4>"Леонардо" '.$rows['name'].'</h4>\'+
						\'<div id="bodyContent">\'+
						\'<p>'.$rows['adress'].', '.$rows['phone'].'</p>\'+
						\'</div>\'+
						\'</div>\';
					';
					$text_leo .= '
						var info_mn_Leo'.$rows['id'].' = new google.maps.InfoWindow({
							content: contentString
						});
					';
					
					$mas_roadmap = explode(",", $rows['roadmap']);
					$roadmap = $mas_roadmap[1].",".$mas_roadmap[0];
					
					$text_leo .= '
					mn_Leo'.$rows['id'].' = new google.maps.Marker({
						position: new google.maps.LatLng('.$roadmap.'),
						map: map,
						icon: mnImage,
						animation: google.maps.Animation.DROP,
						title:"'.$rows['name'].'",
						zIndex: 3});
					';
					
					$text_mn_close .= '
						if (info_mn_Leo'.$rows['id'].') {eval(info_mn_Leo'.$rows['id'].').close();}
					';
					
					$text_leo .= '
					google.maps.event.addListener(mn_Leo'.$rows['id'].', \'click\', function() {
						mn_close();
						info_mn_Leo'.$rows['id'].'.open(map,mn_Leo'.$rows['id'].');
					});
					';
				}

			//} else {
			
				//Опт
				$sql = 'SELECT t1.id, t1.name, t1.adress, t1.phone, t1.pickpoint AS roadmap, t1.city AS city_name FROM {{wheretobuy}} AS t1';
				$command = Yii::app()->db->createCommand($sql);
				$s = $command->queryAll();
				foreach($s as $rows) {
					$rows['name'] = addslashes($rows['name']);
					$rows['adress'] = addslashes($rows['adress']);
					$rows['phone'] = addslashes($rows['phone']);
					$rows['adress'] = str_replace(Array("'","\r","\n"),"",$rows['adress']);
					$text_gamma .= 'var mn_Gammma'.$rows['id'].';';
					
					$text_gamma .= '
						contentString = \'<div id="cont_igla">\'+
						\'<div id="siteNotice_igla">\'+
						\'</div>\'+
						\'<h4>'.$rows['name'].'</h4>\'+
						\'<div id="bodyContent">\'+
						\'<p>'.$rows['adress'].', '.$rows['phone'].'</p>\'+
						\'</div>\'+
						\'</div>\';
					';
					$text_gamma .= '
						var info_mn_Gammma'.$rows['id'].' = new google.maps.InfoWindow({
							content: contentString
						});
					';
					
					$roadmap = $rows['roadmap'];
					
					$text_gamma .= '
					mn_Gammma'.$rows['id'].' = new google.maps.Marker({
						position: new google.maps.LatLng('.$roadmap.'),
						map: map,
						icon: mnImage,
						animation: google.maps.Animation.DROP,
						title:"'.$rows['name'].'",
						zIndex: 3});
					';
					
					$text_mn_close .= '
						if (info_mn_Gammma'.$rows['id'].') {eval(info_mn_Gammma'.$rows['id'].').close();}
					';
					
					$text_gamma .= '
					google.maps.event.addListener(mn_Gammma'.$rows['id'].', \'click\', function() {
						mn_close();
						info_mn_Gammma'.$rows['id'].'.open(map,mn_Gammma'.$rows['id'].');
					});
					';
				}
			//}	
				

				$addtxt .= 'function mn_close()
						{'.$text_mn_close.'}';
				$addtxt .= " if (flag == 0) {".$text_igla."} ";
				$addtxt .= " if (flag == 0) {".$text_leo."} ";
				$addtxt .= " if (flag == 1) {".$text_gamma."} ";
				
				
				$addtxt .= '
}

window.onload = function() {
    map_initialize(0);
}
</script>

	<script>
	
		$(\'.noshow\').hide();
		oncl('.$city_msk_id.');
	</script>
	
	';
			
	
	
	
	echo $addtxt;
	
}
?>

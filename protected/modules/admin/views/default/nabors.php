<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Управление наборами';
$this->breadcrumbs=array(
	'Управление наборами',
);
$nabor = "";
$nabor_add = "";
$onsel = "";
$nabor_get = 0;
if (isset($_GET['nabor'])) $nabor_get = $_GET['nabor'];

$sql = 'SELECT * FROM Goods LEFT JOIN Property ON Goods.GoodID = Property.GoodID and Property.PropertyID = 1 order by Goods.GoodName';
$command=Yii::app()->db->createCommand($sql);
$r=$command->query();
if (sizeof($r) > 0)
{
	foreach($r as $row) {
		if ($nabor_get != $row['GoodID']) $nabor_add .= '<option value="'.$row['GoodID'].'">'.$row['GoodName'].' '.$row['Value'].'</option>';
		if ($nabor_get == $row['GoodID']) $nabor .= '<option selected="selected" value="'.$row['GoodID'].'">'.$row['GoodName'].' '.$row['Value'].'</option>';
		else $nabor .= '<option value="'.$row['GoodID'].'">'.$row['GoodName'].' '.$row['Value'].'</option>';
	}
}
?>

<h1>Управление наборами</h1>
<?php
//echo $_GET['nabor'];

echo '<script type="text/javascript">
			function nabor_go(obj){
				var a = document.location.href;
				var pos = a.indexOf("?nabor=");
				if(-1 !== pos) {
					a = a.substring(0,pos);
				} else {
					pos = a.indexOf("?action=");
					if(-1 !== pos) 
						a = a.substring(0,pos);
				}
				a = a + "?nabor=" + obj.value;
				document.location = a;
			}
			function nabor_add(id,obj){
				$("#ajaxnabor_add").load("/admin/ajaxnaboradd/", {"id":id,"idadd":obj.value});
			}
			function nabor_del(id,iddel){
				if (confirm("Убрать набор из похожих?"))
					$("#ajaxnabor_add").load("/admin/ajaxnabordel/", {"id":id,"iddel":iddel});
			}
		</script>';
?>

<form enctype="multipart/form-data" action="/admin/nabors/" method="GET">
<p>Для набора: <select name="nabor" style="margin-bottom: 0px;" onchange="nabor_go(this);"><option value="0">Выберите набор</option><?php echo $nabor; ?></select></p>
</form>

<?php
if (isset($_POST['send1']))
	{
	//echo $_POST['comm_id'];
	$comment = htmlspecialchars($_POST['s1']);
	$comment = str_replace("'","\"",$comment);
	$sql = "UPDATE {{comment}} SET comment='".$comment."' WHERE (id=".$_POST['comm_id'].")";
	$command=Yii::app()->db->createCommand($sql);
	$r=$command->execute();
	}
	
if ( (isset($_GET['del'])) && (isset($_GET['nabor'])) )
	{
	echo '<span style="color:green;">Комментарий удален!</span><br />';
	$sql = "DELETE FROM {{comment}} WHERE (`id` = ".$_GET['del']." and `good_id` = ".$_GET['nabor'].");";
	$command=Yii::app()->db->createCommand($sql);
	$command->execute();
	}

if ( (isset($_GET['nabor'])) && (isset($_GET['red'])) )
{
	echo '--------------------------------------------------------------------------------------------------------------------------------------<br />';
	echo '<b>Редактирование комментария:</b><br />';
	//echo 'текст';
	
	$sql = 'SELECT * FROM {{comment}} where id='.$_GET['red'];
	$command=Yii::app()->db->createCommand($sql);
	$r=$command->query();
	if (sizeof($r) > 0)
	{
		foreach($r as $row) {
			echo '<form enctype="multipart/form-data" action="/admin/nabors/?nabor='.$_GET['nabor'].'" method="POST">';
			echo '<textarea rows="5" cols="20" style="width:500px;" name="s1">'.$row['comment'].'</textarea>';
			echo '<input name="comm_id" type="hidden" value="'.$row['id'].'">';
			echo '<br /><input type="submit" name="send1" class="" value="Сохранить"></form>';
		}
	}
}
elseif ( (isset($_GET['nabor'])) && ($_GET['nabor'] != 0) )
{
	if (isset($_GET['send']))
	{
		if ($_GET['action'] == 0) {$sql = "DELETE FROM {{akciya}} WHERE `GoodID` = ".$nabor_get.";"; $command=Yii::app()->db->createCommand($sql); $command->execute(); $sql = 'insert into {{akciya}} (id, GoodID, flag) values (NULL, '.$nabor_get.', 0)';}
		elseif ($_GET['action'] == 1) $sql = "DELETE FROM {{akciya}} WHERE `GoodID` = ".$nabor_get.";";
		$command=Yii::app()->db->createCommand($sql);
		$command->execute();
	}
	
	$sql = "SELECT * FROM {{akciya}} where `GoodID` = ".$nabor_get.";";
	$command=Yii::app()->db->createCommand($sql);
	$r=$command->query();
	
	echo '--------------------------------------------------------------------------------------------------------------------------------------<br />';
	echo '<b>Акции:</b>';
	
	echo '
	<form enctype="multipart/form-data" action="/admin/nabors/" method="GET">
	Набор участвует в акции: «Первому сшившему набор – подарок» <select name="action" style="margin-bottom: 0px; width: 65px;">';
	
	if (sizeof($r) == 0) echo '<option selected = "selected" value="1">Да</option><option value="0">Нет</option>';
	else echo '<option value="1">Да</option><option selected = "selected" value="0">Нет</option>';
	
	echo '</select>
	<br /><input name="nabor" type="hidden" value="'.$nabor_get.'">
	<input type="submit" name="send" class="" value="Сохранить">
	</form>';
	
	echo '--------------------------------------------------------------------------------------------------------------------------------------<br />';
	
	echo '<style>
		.nabors_podobie {
			float: left;
		    margin: 5px;
		    padding: 5px;
		    background-color: #F7F5F5;
		}
		.nabors_podobie .imgnab{
			height:100px;
		}
		.nabors_podobie .fkill{
			float: right;
			cursor: pointer;
		}
	</style>';
	
	echo '<b>Похожие наборы:</b>';
	
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
	function imga_pv($filename,$pref)
	{
		$a=md5($filename);
		$path='http://images.firma-gamma.ru/100x100'.$pref.'/'.$a[0].'/'.$a[1].'/'.$filename;
		return $path;
	}
	$sql = 'SELECT * FROM {{podobnye}} where id_nabor='.$nabor_get;
	$command=Yii::app()->db->createCommand($sql);
	$r=$command->query();
	if (sizeof($r) > 0)
	{
		foreach($r as $row) {
			$img2 = "/src/img/opacity.png";
			if (file_exists(imga2("g".$row['id_podob'].'u.jpg',""))) {$img2 = imga_pv("g".$row['id_podob'].'u.jpg',"");}
			echo "<div class='nabors_podobie' style='display: block;' id='naboradd_".$row['id_podob']."'><a href='/catalog/good_".$row['id_podob']."' target='_blank'><img class='imgnab' src='".$img2."' alt=''></a><img onclick='nabor_del(".$nabor_get.",".$row['id_podob'].");' class='fkill' src='/src/img/kill.gif' title='УДАЛИТЬ'></div>";
		}
	}
	
	echo '<div id="nabor_add"></div>';
	
	echo '<div style=" width:100%; height:1px; clear:both;"> </div>';
	echo '<p>Добавить набор: <select name="nabor" style="margin-bottom: 0px;" onchange="nabor_add('.$nabor_get.',this);"><option value="0">Выберите набор</option>'.$nabor_add.'</select></p>';
	echo '<div id="ajaxnabor_add"></div>';
	echo '<br />';
	
	function treeprint_comment($idgood)
	{
		$sql = "select * from {{comment}} where ((good_id = ".$idgood.") and (foto <> 2)) ORDER BY id;";
		$command=Yii::app()->db->createCommand($sql);
		$s=$command->query();
		if (sizeof($s) > 0)
			{
			foreach($s as $row)
				$cat[$row['parent_id']][$row['id']] =  $row;
			
			function comment($cat,$parent_tree,$level,$idgood)
			{
				//global $idgood;
				//$level = 0;
				if (isset($cat[$parent_tree]))
				{
					$tree = "";
					
					$tree .= '<style>#ul_block{list-style: none;}
							#ul_block li {display: block; float: left;}
							#ul_block span {font-size: 24px; cursor: pointer;}
							#ul_block div {text-align: center;}
						</style>';
					$tree .= "<script>
								function ajaxnabor(id,idul,stor)
								{
									if (stor == 1) var str = 'по часовой стрелке';
									else  var str = 'против часовой стрелки';
									if (confirm('Повернуть изображение '+str+'? \\r\\nЧем больше раз поворачиваем, тем хуже становится качество изображения! Желательно не больше 5раз ))')) 
										$('#ajaxnabor_'+idul).load('/admin/ajaxnabor/', {'id':id,'stor':stor});
								}
							</script>";
					
					foreach($cat[$parent_tree] as $ascat)
					{
						$id_now="";
						$id_now_style="";
						$margin_px = 60*$level;
						
						
						
						$tree .= '<div class="comment_tr" style="margin-left:'.$margin_px.'px;">
								<div class="comment_img">&nbsp;</div>
								<div class="comment_block">
									<div class="comment_name">'.$ascat['name'].' // '.$ascat['email'].'</div>
									<div class="comment_data">'.date("d.m.Y, H:i",$ascat['time']).' </div>
									<div class="comment_text">';
									$time = strtotime("now");
									
									if ($ascat['foto'] == 1) {
										$tree .= '<ul id="ul_block">';
										$tree .= '<li id="'.$ascat['id'].'"><a rel="lytebox" href="/images/comment/comm_'.$ascat['id'].'.jpg?v='.$time.'" target="_blank"><img src="/images/comment/comm_'.$ascat['id'].'_sm.jpg?v='.$time.'" alt=""></a>';
										$pathr_orig = $_SERVER['DOCUMENT_ROOT'].'/images/comment/original/comm_'.$ascat['id'].'.jpg';
										$pathr_orig = $_SERVER['DOCUMENT_ROOT'].'/images/comment/original/comm_'.$ascat['id'].'.jpg'; if (file_exists($pathr_orig)) $tree .= '<div><span onclick="ajaxnabor(\''.$ascat['id'].'\','.$ascat['id'].',0);"><</span>&nbsp;&nbsp;&nbsp;<span onclick="ajaxnabor(\''.$ascat['id'].'\','.$ascat['id'].',1);">></span></div>';
										$tree .= '</li>';
										$tree .= '</ul><div style="clear:both;" id="ajaxnabor_'.$ascat['id'].'"> </div>';
									}
									if (($ascat['foto'] == 1) && (strlen($ascat['comment']) > 0) ) $tree .= '<br />';
									
									if ($ascat['foto'] == 3) 
									{
										$tree .= '<ul id="ul_block">';
										$tree .= '<li id="'.$ascat['id'].'_1"><a rel="lyteshow" href="/images/comment/comm_'.$ascat['id'].'_1.jpg?v='.$time.'" target="_blank"><img src="/images/comment/comm_'.$ascat['id'].'_1_sm.jpg?v='.$time.'" alt=""></a>';
											$pathr_orig = $_SERVER['DOCUMENT_ROOT'].'/images/comment/original/comm_'.$ascat['id'].'_1.jpg'; if (file_exists($pathr_orig)) $tree .= '<div><span onclick="ajaxnabor(\''.$ascat['id'].'_1\','.$ascat['id'].',0);"><</span>&nbsp;&nbsp;&nbsp;<span onclick="ajaxnabor(\''.$ascat['id'].'_1\','.$ascat['id'].',1);">></span></div>';
										$tree .= '</li>';
										$tree .= '<li id="'.$ascat['id'].'_2"><a rel="lyteshow" href="/images/comment/comm_'.$ascat['id'].'_2.jpg?v='.$time.'" target="_blank"><img src="/images/comment/comm_'.$ascat['id'].'_2_sm.jpg?v='.$time.'" alt=""></a>';
											$pathr_orig = $_SERVER['DOCUMENT_ROOT'].'/images/comment/original/comm_'.$ascat['id'].'_2.jpg'; if (file_exists($pathr_orig)) $tree .= '<div><span onclick="ajaxnabor(\''.$ascat['id'].'_2\','.$ascat['id'].',0);"><</span>&nbsp;&nbsp;&nbsp;<span onclick="ajaxnabor(\''.$ascat['id'].'_2\','.$ascat['id'].',1);">></span></div>';
										$tree .= '</li>';
										$tree .= '<li id="'.$ascat['id'].'_3"><a rel="lyteshow" href="/images/comment/comm_'.$ascat['id'].'_3.jpg?v='.$time.'" target="_blank"><img src="/images/comment/comm_'.$ascat['id'].'_3_sm.jpg?v='.$time.'" alt=""></a>';
											$pathr_orig = $_SERVER['DOCUMENT_ROOT'].'/images/comment/original/comm_'.$ascat['id'].'_3.jpg'; if (file_exists($pathr_orig)) $tree .= '<div><span onclick="ajaxnabor(\''.$ascat['id'].'_3\','.$ascat['id'].',0);"><</span>&nbsp;&nbsp;&nbsp;<span onclick="ajaxnabor(\''.$ascat['id'].'_3\','.$ascat['id'].',1);">></span></div>';
										$tree .= '</li>';
										$tree .= '<li id="'.$ascat['id'].'_4"><a rel="lyteshow" href="/images/comment/comm_'.$ascat['id'].'_4.jpg?v='.$time.'" target="_blank"><img src="/images/comment/comm_'.$ascat['id'].'_4_sm.jpg?v='.$time.'" alt=""></a>';
											$pathr_orig = $_SERVER['DOCUMENT_ROOT'].'/images/comment/original/comm_'.$ascat['id'].'_4.jpg'; if (file_exists($pathr_orig)) $tree .= '<div><span onclick="ajaxnabor(\''.$ascat['id'].'_4\','.$ascat['id'].',0);"><</span>&nbsp;&nbsp;&nbsp;<span onclick="ajaxnabor(\''.$ascat['id'].'_4\','.$ascat['id'].',1);">></span></div>';
										$tree .= '</li>';
										$tree .= '<li id="'.$ascat['id'].'_5"><a rel="lyteshow" href="/images/comment/comm_'.$ascat['id'].'_5.jpg?v='.$time.'" target="_blank"><img src="/images/comment/comm_'.$ascat['id'].'_5_sm.jpg?v='.$time.'" alt=""></a>';
											$pathr_orig = $_SERVER['DOCUMENT_ROOT'].'/images/comment/original/comm_'.$ascat['id'].'_5.jpg'; if (file_exists($pathr_orig)) $tree .= '<div><span onclick="ajaxnabor(\''.$ascat['id'].'_5\','.$ascat['id'].',0);"><</span>&nbsp;&nbsp;&nbsp;<span onclick="ajaxnabor(\''.$ascat['id'].'_5\','.$ascat['id'].',1);">></span></div>';
										$tree .= '</li>';
										$tree .= '<li id="'.$ascat['id'].'_6"><a rel="lyteshow" href="/images/comment/comm_'.$ascat['id'].'_6.jpg?v='.$time.'" target="_blank"><img src="/images/comment/comm_'.$ascat['id'].'_6_sm.jpg?v='.$time.'" alt=""></a>';
											$pathr_orig = $_SERVER['DOCUMENT_ROOT'].'/images/comment/original/comm_'.$ascat['id'].'_6.jpg'; if (file_exists($pathr_orig)) $tree .= '<div><span onclick="ajaxnabor(\''.$ascat['id'].'_6\','.$ascat['id'].',0);"><</span>&nbsp;&nbsp;&nbsp;<span onclick="ajaxnabor(\''.$ascat['id'].'_6\','.$ascat['id'].',1);">></span></div>';
										$tree .= '</li>';
										$tree .= '<li id="'.$ascat['id'].'_7"><a rel="lyteshow" href="/images/comment/comm_'.$ascat['id'].'_7.jpg?v='.$time.'" target="_blank"><img src="/images/comment/comm_'.$ascat['id'].'_7_sm.jpg?v='.$time.'" alt=""></a>';
											$pathr_orig = $_SERVER['DOCUMENT_ROOT'].'/images/comment/original/comm_'.$ascat['id'].'_7.jpg'; if (file_exists($pathr_orig)) $tree .= '<div><span onclick="ajaxnabor(\''.$ascat['id'].'_7\','.$ascat['id'].',0);"><</span>&nbsp;&nbsp;&nbsp;<span onclick="ajaxnabor(\''.$ascat['id'].'_7\','.$ascat['id'].',1);">></span></div>';
										$tree .= '</li>';
										$tree .= '</ul><div style="clear:both;" id="ajaxnabor_'.$ascat['id'].'"> </div>';
									}
									if (($ascat['foto'] == 3) && (strlen($ascat['comment']) > 0) ) $tree .= '<br />';
									
									
									$tree .= ''.$ascat['comment'].'</div>
									<div class="comment_ans">
									<a href="?nabor='.$_GET['nabor'].'&del='.$ascat['id'].'" onclick="return confirm(\'Удалить комментарий?\')">Удалить</a>
									<a href="?nabor='.$_GET['nabor'].'&red='.$ascat['id'].'">Редактировать</a>
									<!--
									<a href="#" onclick="mainForm_disp(0,'.$ascat['id'].'); $(\'#ajax\').load(\'/ajax/addcomment/\', {\'id\':\''.$ascat['id'].'\', \'parent_id\':\''.$ascat['parent_id'].'\', \'level\':\''.$level.'\', \'idgood\':\''.$idgood.'\'}); return false;">Ответить</a>
									-->
									</div>
								
									<div id="comm_'.$ascat['id'].'">
										
									</div>
								</div>
							</div>';
						$level++;
						$tree .= '<div id="addcomm_'.$ascat['id'].'">';
						$tree .= comment($cat,$ascat['id'],$level,$idgood);
						$tree .= '</div>';
						$level--;
					}
					
				}
				else {return null;}
				return $tree; 
			}
		return comment($cat,0,0,$idgood);
		}
		else return "Комментарии еще не написаны!";
	}
	echo '--------------------------------------------------------------------------------------------------------------------------------------<br />';
	echo '<b>Отзывы и комментарии:</b>';
	echo '<link rel="stylesheet" type="text/css" href="/src/js/lytebox/lytebox.css">';
	echo '<script type="text/javascript" src="/src/js/lytebox/lytebox.js"></script>';
	echo '<div id="addcomm_0">'.treeprint_comment($nabor_get).'</div>';
	
	
	
	echo '<br />';
}
?>

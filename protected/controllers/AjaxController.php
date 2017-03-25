<?php

class AjaxController extends Controller
{
	public function actionCode()
	{
		header ("Content-type: image/png");
		session_start();
		$im = imagecreate(43, 18);
		$font = $_SERVER['DOCUMENT_ROOT'].'/src/font/marmelad.ttf';
		if (isset($_SESSION['code_comment'])) $text = $_SESSION['code_comment']; else $text = "no";
		if (isset($_GET['a']))
			{if ($_GET['a'] == 2) $background = imagecolorallocate($im, 245, 240, 242);}
		else 
			$background = imagecolorallocate($im, 250, 238, 202);
		$textcolor  = imagecolorallocate($im, 0, 0, 0); 
		imagestring($im, 0, 0, 0, "", $background);
		imagettftext($im, 11, 0, 0, 18, $textcolor, $font, $text);
		
		imagepng($im);
		imagedestroy($im);
	}
	
	public function actionAddressboxberry()
	{
	if ( (isset($_POST['id'])) && (isset($_POST['sel'])) )
		{
		$id = $_POST['id'];
		$sel = $_POST['sel'];
		if (($id != "Выбрать...") && (strlen($id)>0))
			{
			$sql = "select id,address from boxberry where city='".$id."' ORDER BY id";
			$command=Yii::app()->db->createCommand($sql);
			$r=$command->query();
			echo '<script>$(\'#div_boxberry_text\').show();</script>
			<select id="city_boxberry_ul" name="city_boxberry_ul" value="Выберите значение">';
			if (sizeof($r) > 1) echo '<option value="0">Выберите адрес...</option>';
			foreach($r as $s) 
				{
				echo "<option value='".$s['id']."'";
				if ($sel == $s['id']) echo " selected";
				echo ">".$s['address']."</option>";
				}
			echo "</select>";
			}
		else echo '<script>$(\'#div_boxberry_text\').hide();</script>';
		}
	}
	
	public function actionVrating()
	{
		if (!isset($_POST['num'])) throw new CHttpException(404,'The requested page does not exist.');
		$num = $_POST['num'];
		$num_txt = $num;
		$num_base = $num;
		if ($num == 6) {$num_txt = "5+"; $num_base = 5.5;}
		$idgood = $_POST['idgood'];
		$kol = 0;
		$ocenka = 0;
		
		$ip = Yii::app()->request->userHostAddress;
		
		$sql = 'insert into {{rating}} (id, id_nabor, ip, ball, moment) values (NULL, '.$idgood.', \''.$ip.'\', '.$num_base.', '.strtotime("now").')';
		$command=Yii::app()->db->createCommand($sql);
		$command->execute();
		
		$sql = 'select * from {{rating_total}} where id_nabor='.$idgood;
		$command=Yii::app()->db->createCommand($sql);
		$r1=$command->query();
		if (sizeof($r1) == 0)
		{
			$kol = 1;
			$itogo = $num_base;
			$sql = 'insert into {{rating_total}} (id, id_nabor, sum, kol, itogo) values (NULL, '.$idgood.', '.$num_base.', '.$kol.', '.$itogo.')';
			$command=Yii::app()->db->createCommand($sql);
			$command->execute();
		}
		else
		{
			foreach($r1 as $s1)
			{
				$kol = $s1['kol'] + 1;
				$sum = $s1['sum'] + $num_base;
				$itogo = $sum/$kol;
				$sql = 'update {{rating_total}} set sum='.$sum.', kol='.$kol.', itogo='.$itogo.' where id_nabor='.$idgood;
				$command=Yii::app()->db->createCommand($sql);
				$command->execute();
			}
		}
		
		$ocenka = round($itogo,2);
		if ($ocenka>5) $ocenka='5+';
		
		//echo "<script>alert('".$ip."'); </script>";
		echo "<script>$('.cat-baln ul').remove(); </script>";
		$tekst = '<div id="cat_ball_one">'.$num_txt.'</div><div class="both"></div>';
		echo "<script>$('.cat-baln').append('".$tekst."'); </script>";
		echo "<script>$('#cat-bal-up').empty(); </script>";
		$tekst = 'Средняя оценка: '.$ocenka.' <br />Количество оценок: '.$kol;
		echo "<script>$('#cat-bal-up').append('".$tekst."'); </script>";
	}
	
	public function actionAddcomment()
	{
		if (!isset($_POST['id'])) throw new CHttpException(404,'The requested page does not exist.');
		session_start();
		$id = $_POST['id'];
		$parent_id = $_POST['parent_id'];
		$level = $_POST['level'];
		$idgood = $_POST['idgood'];
		$action_flag = $_POST['action_flag'];
		$action_tekst = '';
		if ($action_flag == 0) $action_tekst = '<p style="color: #9c4f6b;"><b>Внимание!</b> Набор не участвует в акции: <a href="/action/" target="_blank" style="color: #55a8cf;"> «Первому сшившему набор – подарок»</a></p>';
			
		if (isset($_SESSION['name_comment'])) $name_comment=$_SESSION['name_comment']; else $name_comment = "";
		if (isset($_SESSION['email_comment'])) $email_comment=$_SESSION['email_comment']; else $email_comment = "";
		$code_comment = rand(10000, 99999);
		$_SESSION['code_comment'] = $code_comment;
		$tekst = '<form enctype="multipart/form-data" action="/ajax/uploader/" method="POST" id="mainForm" class="mainForm"><div id="results"></div><input name="parent_id" id="parent_id" type="hidden" value="'.$parent_id.'"> <input name="level" id="level" type="hidden" value="'.$level.'"> <input name="idadd" id="idadd" type="hidden" value="'.$id.'"> <input name="idpage" id="idpage" type="hidden" value="1"><input name="typepage" id="typepage" type="hidden" value="5"><input name="code" id="code" type="hidden" value="'.md5($code_comment).'"><input name="idgood" id="idgood1" type="hidden" value="'.$idgood.'"><div class="comment_ans_bl"><div class="comment_ans_inp"> <img style="display:none; float:right;" id="loader" src="/src/img/loader.gif" alt="Loading...." title="Loading...." /> <p><span style="color:red;">*</span>&nbsp;Ваше имя: <input type="text" name="s1" id="s1" value="'.$name_comment.'" class="comment_input"><span style="color:red;" id="er_s1"></p><p></span> Ваш e-mail: <input type="text" name="s2" id="s2" value="'.$email_comment.'" class="comment_input"><span style="color:red;" id="er_s2"></span></p>'.$action_tekst.'<p>Загрузить фото Вашей работы: <input id="uploadImage" type="file" accept="image/*" name="image"/></p><p class="comment_ans_text">Ваш комментарий к отзыву:<br /><textarea rows="3" name="s3" id="s3" value="" class="search-text"></textarea></p><p style="color:red;" id="er_s3"></p><p>Введите проверочный код&nbsp;&nbsp;<img src="/ajax/code/?a=2" border="0" alt="" style="margin: 0px; height: 18px;" />:&nbsp;<input type="text" name="s4" id="s4" value="" class="comment_input_ye" style="width:50px;"><span style="color:red;" id="er_s4"></span></p><p><input id="button" type="submit" class="comment_ans_sub" value=""><div class="comment_not"><a onclick="mainForm(); return false;" href="">Не хочу комментировать</a></div></p><br /></div></div></form>';

		echo "<script>$('.loader_comm').css('display','none'); </script>";
		echo "<script>$('.mainForm').remove(); </script>";
		echo "<script>$('#comm_".$id."').append('".$tekst."');</script>";
		echo '<script>$("#mainForm").submit(function (event) {$("#results").empty();event.preventDefault();var data = new FormData($("#mainForm")[0]); data.append("parent_id",$("#parent_id").val()); data.append("level",$("#level").val()); data.append("s1",$("#s1").val()); data.append("s2",$("#s2").val()); data.append("s3",$("#s3").val()); data.append("s4",$("#s4").val()); data.append("code",$("#code").val()); data.append("idadd",$("#idadd").val()); data.append("idpage",$("#idpage").val());data.append("typepage",$("#typepage").val());$.ajax({type: "POST",url: "/ajax/uploader/",data: data,contentType: false,processData: false,cache: false,beforeSend: function() {$("#loader").show();}}).done(function (html) {$("#results").empty();$("#results").append(html);$("#loader").hide(); /*if ($("#mainForm")[0]) $("#mainForm")[0].reset();*/});});</script>';
		
	}
	
	public function actionBasket()
	{
		if (!isset($_POST['id'])) throw new CHttpException(404,'The requested page does not exist.');
		session_start();

		$type = 0;
		$idz = $_POST['id'];
		$kol = $_POST['pr'];
		if (isset($_POST['type'])) $type = $_POST['type'];
	
		if ($idz != 0)
		{
			if(isset($_SESSION['basket_goods'])) $basket_goods=$_SESSION['basket_goods']; else $basket_goods=0;
			if(isset($_SESSION['basket_id'])) $basket_id=$_SESSION['basket_id']; else $basket_id=NULL;
			if(isset($_SESSION['basket_col'])) $basket_col=$_SESSION['basket_col']; else $basket_col=NULL;
			
			$addidz=explode("|",$idz);
			$kolidz=count($addidz);
			// если корзина пуста
			$kol=intval($kol,10);
			$kol=intval($kol,10);
			
			if ($type == 1) $kol=$kol+1;
			elseif ($type == 2) $kol=$kol-1;
			
			if (isset($kol)&&(intval($kol,10)>=0))
			if($basket_goods==0)
			{
				$switch=0;
				$basket_id=$idz;
				for($i=0;$i<$kolidz;$i++) 
					if($kol>=0)
					{
						$rrl[$basket_goods]=$addidz[$i];
						$rrl2[$basket_goods]=$kol;
						$basket_goods++;
						$switch=1;
					}
				if($switch==1)
				{
					$basket_col=implode("|",$rrl2);
					$idzgoods=implode("|",$rrl);
					$basket_id=$idzgoods;
					$_SESSION['basket_goods']=$basket_goods;
					$_SESSION['basket_id']=$idzgoods;
					$_SESSION['basket_col']=$basket_col;
				}
			} else
			// если корзина уже не пустая
			{
				$basket_id_mas=explode("|",$basket_id);
				$fnded=-1;
				for($i=0;$i<$kolidz;$i++)
				{
					if($kol>=0)
					{
						$fnded=-1;
						for($j=0;$j<$basket_goods;$j++)
						{
							if($basket_id_mas[$j]==$addidz[$i]) $fnded=$j;
						}
						if($fnded==-1)
						{
							$basket_id.="|".$addidz[$i];
							$basket_goods++;
							$basket_col.="|".$kol;
						} else
						{
							$basket_col_mas=explode("|",$basket_col);
							if ($type == 1) $basket_col_mas[$fnded]=$kol;
							elseif ($type == 2) $basket_col_mas[$fnded]=$kol;
							else $basket_col_mas[$fnded]+=$kol;
							$basket_col=implode("|",$basket_col_mas);
						}
					}
				}
				
				$_SESSION['basket_goods']=$basket_goods;
				$_SESSION['basket_id']=$basket_id;
				$_SESSION['basket_col']=$basket_col;
			}
		if (($type != 1) && ($type != 2)) echo '<script> basket();</script>';
		}
		
		if(isset($_SESSION['basket_goods'])) $basket_goods=$_SESSION['basket_goods']; else $basket_goods=0;
		if(isset($_SESSION['basket_id'])) $basket_id=$_SESSION['basket_id']; else $basket_id=0;
		if(isset($_SESSION['basket_col'])) $basket_col=$_SESSION['basket_col']; else $basket_col=0;

		if ($basket_goods == 0)
			echo 'Корзина пуста 
			<script>
				$("#basket").hide(); basket_close = 1;
				if ($("#ajaxcart_my")[0]){
					$("#ajaxcart_my")[0].innerHTML = \'Товаров: <span id="basket_count">0</span> шт.<br />На сумму: <span id="basket_price">0</span> руб.\';
				}
				$(".opacity").remove();
			</script>';
		
		else {
			$tot=0;
			$tot_kol=0;
			$mas_goods=explode("|",$basket_id);
			$mas_cols=explode("|",$basket_col);	
						
			for($e=0;$e<$basket_goods;$e++)
			{				
				$sql = "select price from Goods where GoodID=".$mas_goods[$e]." GROUP BY GoodID;";
				$command=Yii::app()->db->createCommand($sql);
				$s=$command->queryScalar();
				if ($s){
					$pr=$s*$mas_cols[$e];
					$tot_kol=$tot_kol+$mas_cols[$e];
					$tot+=$pr;
					
					if ( ($idz == $mas_goods[$e]) && ($type != 0) )
						echo "
						<script>
						document.getElementById('prs'+".$idz.").innerHTML = '".$pr."руб.';
						</script>";
				}
			}
			echo "Товаров: $tot_kol шт.<br /> На сумму: $tot руб. ";
			echo '<script> 
			
			if ($("#basket_count")[0]){
				if ($("#basket_count")[0]) $("#basket_count")[0].innerHTML = '.$tot_kol.';
				if ($("#basket_price")[0]) $("#basket_price")[0].innerHTML = '.$tot.';
				}
			else{
				if ($("#ajaxcart_my")[0]){
					$("#ajaxcart_my")[0].innerHTML = \'Товаров: <span id="basket_count">'.$tot_kol.'</span> шт.<br />На сумму: <span id="basket_price">'.$tot.'</span> руб.\';
				}
				else alert("123");
			}
			
			if (basket_close == 1) basket_close = 0;
			
			</script>';			
			if ($type != 0)
				echo "
				<script>
					document.getElementById('basket-all').innerHTML = '".$tot."руб.';
				</script>";
			
		}
	}
	
	public function actionImageadd()
	{
		umask(0002);
		$callback = $_GET['CKEditorFuncNum'];
		if ($_GET['id'] > 0) $id = $_GET['id'];
		else exit();
		$field = $_GET['fieldtxt'];
		if (strcmp($field,"news/") == 0) $field_txt = "news";
		elseif (strcmp($field,"tekst/") == 0) $field_txt = "mc";
		elseif (strcmp($field,"articles_tekst/") == 0) $field_txt = "articles";
		else exit();
	    $file_name = $_FILES['upload']['name'];
	    $file_name_tmp = $_FILES['upload']['tmp_name'];
	    $file_new_name = $_SERVER['DOCUMENT_ROOT'].'/images/'.$field_txt.'/'.$id.'/';
	    $full_path = $file_new_name.$file_name;
	    $http_path = '/images/'.$field_txt.'/'.$id.'/'.$file_name;
	    $error = '';
	    if( move_uploaded_file($file_name_tmp, $full_path) )
	    {
	    	$x = 700;
			$img=imagecreatefromjpeg($full_path);
			$size = getimagesize($full_path);
			if ($img)
			{
				if ($size[0]>$x)
				{
					//Ширина изображения больше чем нужно
					$scale=$x/$size[0];
					$y = $size[1] * $scale;
					$target=imagecreatetruecolor($x,$y);
					imagecopyresampled($target,$img,0,0,round(($size[0]-$x/$scale)/2),0,$x,$y,round($x/$scale),$size[1]);
					if (file_exists($full_path)) unlink($full_path);
					imagejpeg($target,$full_path);
				}
			}
			
			//watermark
			$logo_file = $_SERVER['DOCUMENT_ROOT']."/src/img/miadolla-logo.png"; 
			$logo_file_miadollaru = $_SERVER['DOCUMENT_ROOT']."/src/img/miadollaru.png";
			$image_file = $_SERVER['DOCUMENT_ROOT'].$http_path; 
			$targetfile = $_SERVER['DOCUMENT_ROOT'].$http_path; 
			$photo = imagecreatefromjpeg($image_file); 
			$fotoW = imagesx($photo); 
			$fotoH = imagesy($photo); 
			$logoImage = imagecreatefrompng($logo_file); 
			$logoImage_miadollaru = imagecreatefrompng($logo_file_miadollaru); 
			$logoW = imagesx($logoImage); 
			$logoH = imagesy($logoImage); 
			$logoW_miadollaru = imagesx($logoImage_miadollaru); 
			$logoH_miadollaru = imagesy($logoImage_miadollaru); 
			$photoFrame = imagecreatetruecolor($fotoW,$fotoH); 
			$dest_x = $fotoW - $logoW; 
			$dest_y = $fotoH - $logoH; 
			imagecopyresampled($photoFrame, $photo, 0, 0, 0, 0, $fotoW, $fotoH, $fotoW, $fotoH); 
			imagecopy($photoFrame, $logoImage, $dest_x, $dest_y, 0, 0, $logoW, $logoH); 
			
			imagecopy($photoFrame, $logoImage_miadollaru, 5, 5, 0, 0, $logoW_miadollaru, $logoH_miadollaru);
			
			imagejpeg($photoFrame, $targetfile); 

	    } else {
	    	$error = 'Some error occured please try again later';
	    	$http_path = '';
	    }
	    echo "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(".$callback.",  \"".$http_path."\", \"".$error."\" );</script>";
	}
	
	public function actionCrop()
	{
		//echo "test"; 
		//echo "12345"; exit();
		$dst_w = round($_POST['width']*(1/$_POST['scale']));
        $dst_h = round($_POST['height']*(1/$_POST['scale']));
        
        if (($_POST['size_w']>0) && ($_POST['size_h']>0))
        	{
        	$dst_w = $_POST['size_w'];
        	$dst_h = $_POST['size_h'];
        	}
    	elseif (($_POST['size_w']>0) && ($_POST['size_h']==0))
        	{
        	$dst_w = $_POST['size_w'];
        	
        	$dst_h = round($_POST['height']*($dst_w/$_POST['width']));
        	}
        
        $quality = 80;
      	$src_path = $_POST['name_file'];
   
        $outfile_path = $_POST['name_file_thumb'];
        $outfile_path_thumb = $outfile_path.".tmp.jpg";
      	$outfile_path = $outfile_path.".jpg";

        //."_thumb.jpg";
        $src_image = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].$src_path);
        $dst_image = imagecreatetruecolor($dst_w, $dst_h);
        
        $koef_new=imagesx($src_image) / $_POST['src_width'];
        $_POST['x'] = $_POST['x']*$koef_new;
        $_POST['y'] = $_POST['y']*$koef_new;
        $_POST['width'] = $_POST['width']*$koef_new;
        $_POST['height'] = $_POST['height']*$koef_new;

        imagecopyresampled($dst_image, $src_image, 0, 0, $_POST['x'],
                           $_POST['y'], $dst_w, $dst_h, $_POST['width'],
                           $_POST['height']);
                           

        imagedestroy($src_image);
        //$outfile_path;
        imagejpeg($dst_image, $_SERVER['DOCUMENT_ROOT'].$outfile_path, $quality);
        imagedestroy($dst_image);

        $size = getimagesize($_SERVER['DOCUMENT_ROOT'].$outfile_path);
		$img = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].$outfile_path);
		if ($img)
		{
	        $target = imagecreatetruecolor(70,70);
			imagecopyresampled($target,$img,0,0,0,0,70,70,$size[0],$size[1]);
			imagejpeg($target, $_SERVER['DOCUMENT_ROOT'].$outfile_path_thumb, $quality);
		}
		
		$file_th = $_SERVER['DOCUMENT_ROOT'].$outfile_path_thumb;
		if (file_exists($file_th)) unlink($file_th);
		
		if (file_exists($_SERVER['DOCUMENT_ROOT'].$outfile_path))
		{
			$randnum = rand();
			$imgsrc = $outfile_path.'?d='.$randnum;
			
			if ( ($_POST['type_load'] == 1) || ($_POST['type_load'] == 3) || ($_POST['type_load'] == 4) )
			{
				echo "<script>
					$('#img_smin').attr('src','".$imgsrc."');
					$('#scr_foto".$_POST['type_load']."').remove();
					$('#fotowork".$_POST['type_load']."').remove();
				</script>";
			}
			elseif ($_POST['type_load'] == 2)
			{
				echo "<script>
					$('#img_smin2').attr('src','".$imgsrc."');
					$('#scr_foto".$_POST['type_load']."').remove();
					$('#fotowork".$_POST['type_load']."').remove();
				</script>";
			}
		}
	}
	
	public function actionBasketclear()
	{
		session_start();
		if(isset($_SESSION['basket_goods'])) $_SESSION['basket_goods'] = 0;
		if(isset($_SESSION['basket_id'])) $_SESSION['basket_id'] = "";
		if(isset($_SESSION['basket_col'])) $_SESSION['basket_col'] = "";
		echo "
			<script>
				
				add2cart(this,0,0);
			</script>";
	}
	
	public function actionBasketprod()
	{
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
		
		session_start();
		if(isset($_SESSION['basket_goods'])) $basket_goods=$_SESSION['basket_goods']; else $basket_goods=0;
		if(isset($_SESSION['basket_id'])) $basket_id=$_SESSION['basket_id']; else $basket_id=0;
		if(isset($_SESSION['basket_col'])) $basket_col=$_SESSION['basket_col']; else $basket_col=0;

		if ($basket_goods != 0) {

			$totall=0;
			$mas_goods=explode("|",$basket_id);
			$mas_cols=explode("|",$basket_col);	
						
			for($e=0;$e<$basket_goods;$e++)
			{
				$sql = "select * from Goods where GoodID=".$mas_goods[$e]." GROUP BY GoodID;";
				$command=Yii::app()->db->createCommand($sql);
				$r=$command->query();
				$tot=0;
				foreach($r as $s)
				{
					if (file_exists(imga2("g".$s['GoodID'].'.jpg',""))) $img1 = "<img src=\"".imga("g".$s['GoodID'].'.jpg',"")."\">";
					elseif (file_exists(imga2("g".$s['GoodID'].'u.jpg',""))) $img1 = "<img src=\"".imga("g".$s['GoodID'].'u.jpg',"")."\">";
					else $img1 = "<img src=\"/src/img/opacity.png\">";
		
					$tot = $mas_cols[$e]*$s['Price'];
					$totall = $totall+$tot;
					echo $img1.'
						<div class="basket_name">'.$s['GoodName'].'<br /><span>'.$s['Price'].'руб.</span></div>
						<div class="basket_count">
							<ul class="cat_count">
								<li class="cat_count_l" onclick="kol_minus(document.getElementById(\'prb'.$s['GoodID'].'\').innerHTML,\''.$s['GoodID'].'\',2); return false;"><a href="">-</a></li>
								<li id="prb'.$s['GoodID'].'" class="cat_count_c">'.$mas_cols[$e].'</li>
								<li class="cat_count_r" onclick="kol_plus(document.getElementById(\'prb'.$s['GoodID'].'\').innerHTML,\''.$s['GoodID'].'\',1); return false;"><a href="">+</a></li>
							</ul>
						</div>
						<div class="basket_price" id="prs'.$s['GoodID'].'">'.$tot.'руб.</div>
						
						<div class="both" style="height:15px;"></div>	
					';
				}
			}
			$totall .="руб."; 
			echo "<script>document.getElementById('basket-all').innerHTML = '".$totall."';</script>";			
		}
		else echo "Корзина пуста!";
	}
	
	public function actionAddaction()
	{
		session_start();
		$error = 0;

		if (isset($_POST['save_act']))
		{
			$idgood_act = $_POST['idgood_act'];
			$idcomment = $_POST['idcomment'];
			$sql = "UPDATE {{comment}} SET `foto` = '3' WHERE `id` = ".$idcomment.";";
			$command=Yii::app()->db->createCommand($sql);
			$command->execute();
			
			$sql='SELECT * FROM {{comment}} WHERE id='.$idcomment;
			$command=Yii::app()->db->createCommand($sql);
			$s=$command->queryAll();
			foreach($s as $row)
			{
				$tekst = '<div class="comment_tr" style="margin-left:0px;"><div class="comment_img">&nbsp;</div><div class="comment_block"><div class="comment_name">'.$row['name'].'</div><div class="comment_data">'.date("d.m.Y, H:i",$row['time']).'</div>';

				$tekst .= '<a rel="lytebox" onclick="myLytebox.start(this); return false;" href="/images/comment/comm_'.$idcomment.'_1.jpg" target="_blank"><img src="/images/comment/comm_'.$idcomment.'_1_sm.jpg" alt=""></a>';
				$tekst .= '<a rel="lytebox" onclick="myLytebox.start(this); return false;" href="/images/comment/comm_'.$idcomment.'_2.jpg" target="_blank"><img src="/images/comment/comm_'.$idcomment.'_2_sm.jpg" alt=""></a>';
				$tekst .= '<a rel="lytebox" onclick="myLytebox.start(this); return false;" href="/images/comment/comm_'.$idcomment.'_3.jpg" target="_blank"><img src="/images/comment/comm_'.$idcomment.'_3_sm.jpg" alt=""></a>';
				$tekst .= '<a rel="lytebox" onclick="myLytebox.start(this); return false;" href="/images/comment/comm_'.$idcomment.'_4.jpg" target="_blank"><img src="/images/comment/comm_'.$idcomment.'_4_sm.jpg" alt=""></a>';
				$tekst .= '<a rel="lytebox" onclick="myLytebox.start(this); return false;" href="/images/comment/comm_'.$idcomment.'_5.jpg" target="_blank"><img src="/images/comment/comm_'.$idcomment.'_5_sm.jpg" alt=""></a>';
				$tekst .= '<a rel="lytebox" onclick="myLytebox.start(this); return false;" href="/images/comment/comm_'.$idcomment.'_6.jpg" target="_blank"><img src="/images/comment/comm_'.$idcomment.'_6_sm.jpg" alt=""></a>';
				$tekst .= '<a rel="lytebox" onclick="myLytebox.start(this); return false;" href="/images/comment/comm_'.$idcomment.'_7.jpg" target="_blank"><img src="/images/comment/comm_'.$idcomment.'_7_sm.jpg" alt=""></a>';

				$tekst .= '<br /><div class="comment_text">'.$row['comment'].'</div><div class="comment_ans"><a href="#" onclick="mainForm_disp(0,'.$idcomment.'); comm_id('.$idcomment.',0,0,'.$idgood_act.'); return false;">Ответить</a></div><div id="comm_'.$idcomment.'"></div></div></div><div id="addcomm_'.$idcomment.'"></div>';
				echo "<script>$('#addcomm_0').append('".str_replace(array("\n","\r"), '', $tekst)."');</script>";
				echo "<script>scroll_to_bottom(1);</script>";
				$time = $row['time'];
				$email = $row['email'];
				$comment = $row['comment'];
				$foto_send = '
				<img src="http://miadolla.ru/images/comment/comm_'.$idcomment.'_1_sm.jpg" alt="">
				<img src="http://miadolla.ru/images/comment/comm_'.$idcomment.'_2_sm.jpg" alt="">
				<img src="http://miadolla.ru/images/comment/comm_'.$idcomment.'_3_sm.jpg" alt="">
				<img src="http://miadolla.ru/images/comment/comm_'.$idcomment.'_4_sm.jpg" alt="">
				<img src="http://miadolla.ru/images/comment/comm_'.$idcomment.'_5_sm.jpg" alt="">
				<img src="http://miadolla.ru/images/comment/comm_'.$idcomment.'_6_sm.jpg" alt="">
				<img src="http://miadolla.ru/images/comment/comm_'.$idcomment.'_7_sm.jpg" alt="">
				<br />';
			}
			echo "<script> $('.opacity_action').remove(); </script>";
			
			
			
			
			
			
					$mail_send1 = "khaziyev_m@sb-service.ru";
					$mail_send2 = "toys@miadolla.ru";
					
					$headers = "From: Miadolla.Ru <toys@miadolla.ru> \r\n";
					$su='Новый комментарий для акции «Первому сшившему набор – Подарок»  на Miadolla.Ru';
					$su = iconv("utf-8", "windows-1251", $su);
					$subj ='=?windows-1251?B?'.base64_encode($su).'?=';
					$headers.= "Content-Type: text/html; charset=Windows-1251\r\n";
					$headers.= "MIME-Version: 1.0\r\n";
					
					$mailbody ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
						<html>
						<head>
						<title>miadolla.ru - комментарий на сайте для акции «Первому сшившему набор – Подарок»</title>
						<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
						</head>
						<style>
						h1
						{
							font-family:Arial, Helvetica, sans-serif;
							font-size:16px;
							font-weight:bold;
						}
						h2
						{
							font-family:Arial, Helvetica, sans-serif;
							font-size:14px;
							font-weight:bold;
						}
						p
						{
							font-family:Arial, Helvetica, sans-serif;
							font-size:12px;
						}
						</style>
						<body>
						<h1>Новый комментарий для акции «Первому сшившему набор – Подарок» на сайте Miadolla.Ru</h1>
						<p>На сайте Miadolla.Ru новый комментарий <a href="http://miadolla.ru/catalog/good_'.$idgood_act.'" target="_blank">к набору</a></p>
						<p><b>Дата и время:</b> '.date("d.m.Y, H:i",$time).'</p>';
						if (strlen($email) > 0) $mailbody .='<p><b>E-mail:</b> '.$email.'</p>';
						$mailbody .= '<p><b>Комментарий:</b> '.$foto_send.$comment.'</p>
						<p><a href="http://www.miadolla.ru/admin/" target="_blank">Панель управления</a></p>
						</body>
						</html>';
					
					$mailbody = iconv("utf-8", "windows-1251", $mailbody);
					$headers = iconv("utf-8", "windows-1251", $headers);
					mail($mail_send1, $subj, $mailbody, $headers);
					mail($mail_send2, $subj, $mailbody, $headers);
			
			
			
			
			
			
			exit();
		}
		elseif (isset($_POST['flag']))
		{
			$sellc = $_POST['sellc'];
			$idcomment = $_POST['idcomment'];

			if ($sellc == 0) {echo "<script>alert('Выберите тип фото для загрузки!');</script>"; exit();}

			if(isset($_FILES['image']))
			{
				$pathr=$_SERVER['DOCUMENT_ROOT'].'/images/comment/comm_'.$idcomment.'_'.$sellc.'.jpg';
				$pathr_sm=$_SERVER['DOCUMENT_ROOT'].'/images/comment/comm_'.$idcomment.'_'.$sellc.'_sm.jpg';
				$pathr_orig=$_SERVER['DOCUMENT_ROOT'].'/images/comment/original/comm_'.$idcomment.'_'.$sellc.'.jpg';
				umask(0002);

				$extensions = array('jpeg', 'jpg');
				$response = '';
				$max_size = 1;
				if ( ($_FILES['image']['error'] > 0) && ($_FILES['image']['error'] < 4) )
				{
					$response = 'Размер изображения слишком большой (должно быть не более 4Мб)';
					echo "<script>alert('".$response."');</script>";
					exit();
				}
				else {
					$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
					if ($_FILES['image']['error'] == 0)
					if (in_array($ext, $extensions))
					{

						if (!move_uploaded_file($_FILES['image']['tmp_name'],$pathr)) { echo "<script> alert('Выберите фото для загрузки!');</script>";}
						else {
		
					    	$x = 700;
					    	$y_sm = 70;
					    	$y_size = 200;
							$img=imagecreatefromjpeg($pathr);
							$size = getimagesize($pathr);
							
							if ($img)
								if ( ($size[0]<$y_size) || ($size[1]<$y_size) )
								{
									$response = 'Изображение слишком маленькое (должно быть не менее '.$y_size.'px по длине или ширине)';
									echo "<script>alert('".$response."');</script>";
									exit();
								}
							
							if ($img)
							{
								if ($size[0]>$x)
								{
									//Ширина изображения больше чем нужно
									$scale=$x/$size[0];
									$y = $size[1] * $scale;
									$target=imagecreatetruecolor($x,$y);
									imagecopyresampled($target,$img,0,0,round(($size[0]-$x/$scale)/2),0,$x,$y,round($x/$scale),$size[1]);
									if (file_exists($pathr)) unlink($pathr);
									imagejpeg($target,$pathr);
								}
								//превью по высоте
								if ($size[1]>$y_sm)
								{
									$scale=$y_sm/$size[1];
									$x = $size[0] * $scale;
									$target=imagecreatetruecolor($x,$y_sm);
									imagecopyresampled($target,$img,0,0,0,round(($size[1]-$y_sm/$scale)/2),$x,$y_sm,$size[0],round($y_sm/$scale));
									imagejpeg($target,$pathr_sm);
								}
								//сохранение оригинала
								if (file_exists($pathr)) copy($pathr, $pathr_orig);
							}
							//watermark
							$logo_file = $_SERVER['DOCUMENT_ROOT']."/src/img/miadolla-logo.png"; 
							$image_file = $pathr; 
							$targetfile = $pathr; 
							$photo = imagecreatefromjpeg($image_file); 
							$fotoW = imagesx($photo); 
							$fotoH = imagesy($photo); 
							$logoImage = imagecreatefrompng($logo_file); 
							$logoW = imagesx($logoImage); 
							$logoH = imagesy($logoImage); 
							$photoFrame = imagecreatetruecolor($fotoW,$fotoH); 
							$dest_x = $fotoW - $logoW; 
							$dest_y = $fotoH - $logoH; 
							imagecopyresampled($photoFrame, $photo, 0, 0, 0, 0, $fotoW, $fotoH, $fotoW, $fotoH); 
							imagecopy($photoFrame, $logoImage, $dest_x, $dest_y, 0, 0, $logoW, $logoH); 
							imagejpeg($photoFrame, $targetfile); 
		
							echo "<script> $('#actionForm')[0].reset(); </script>";
							echo "<script> if ($('#li_act_1').css('display') != 'none' ) $('#select_id [value=1]').remove();</script>";
							echo "<script> if ($('#li_act_2').css('display') != 'none' ) $('#select_id [value=2]').remove();</script>";
							echo "<script> if ($('#li_act_3').css('display') != 'none' ) $('#select_id [value=3]').remove();</script>";
							echo "<script> if ($('#li_act_4').css('display') != 'none' ) $('#select_id [value=4]').remove();</script>";
							echo "<script> if ($('#li_act_5').css('display') != 'none' ) $('#select_id [value=5]').remove();</script>";
							echo "<script> if ($('#li_act_6').css('display') != 'none' ) $('#select_id [value=6]').remove();</script>";
							echo "<script> if ($('#li_act_7').css('display') != 'none' ) $('#select_id [value=7]').remove();</script>";
							if ($sellc != 0) echo "<script>$('#li_act_".$sellc."').css('display','block'); $('#select_id [value=".$sellc."]').remove();</script>";
							echo "<script> if ($('select[id=select_id] option').size() == 1) $('.action_load').css('display','none'); else $('.action_load').css('display','block');</script>";
							echo "<script> if ($('select[id=select_id] option').size() == 1) $('.action_save').css('display','block'); else $('.action_save').css('display','none');</script>";
		
							$random = rand(99999, 99999999);
							echo "<script> $('#foto_act_".$sellc."').attr('src','/images/comment/comm_".$idcomment."_".$sellc."_sm.jpg?r=".$random."'); </script>";
							echo "<script> $('#hr_foto_act_".$sellc."').attr('href','/images/comment/comm_".$idcomment."_".$sellc.".jpg?r=".$random."'); </script>";
								
						}
				
				
				} else {
						$response = 'Изображение имеет неверный формат (поддерживаются только в форматах: jpeg, jpg)';
						echo "<script>alert('".$response."');</script>";
					}
				}

			}
		}
		elseif (isset($_POST['a1']))
		{
			echo "<script>$('#er_a1').empty();</script>";
			if (strlen($_POST['a1']) == 0) {echo "<script>$('#er_a1').append('&nbsp;введите имя')</script>"; $error++;}
			echo "<script>$('#er_a2').empty();</script>";
			if (strlen($_POST['a2']) == 0) {echo "<script>$('#er_a2').append('&nbsp;введите e-mail')</script>"; $error++;}
			else {if (!preg_match("/^([a-zA-Z0-9_\.-]+)@([a-zA-Z0-9_\.-]+)\.([a-zA-Z\.]{2,6})$/", $_POST['a2'])) {echo "<script>$('#er_a2').append('&nbsp;неверный e-mail')</script>"; $error++;}
			}
			echo "<script>$('#er_a3').empty();</script>";
			if (strlen($_POST['a3']) == 0) {echo "<script>$('#er_a3').append('&nbsp;Необходимо ответить на вопросы')</script>"; $error++;}
			
			$idgood_act = $_POST['idgood_act'];
			$_SESSION['name_comment'] = $_POST['a1'];
			$_SESSION['email_comment'] = $_POST['a2'];
			$name = htmlspecialchars($_POST['a1']);
			$email = htmlspecialchars($_POST['a2']);
			$comment = htmlspecialchars($_POST['a3']);
			$comment = str_replace("'","\"",$comment);
			$name = str_replace("'","\"",$name);
			$time = strtotime("now");
			
			$id = 0;
			
			if ($error == 0)
			{
				$sql = "INSERT INTO {{comment}} (id, parent_id, good_id, name, email, foto, level,comment,time) VALUES(NULL, 0, '".$idgood_act."', '".$name."', '".$email."', 2, 0, '".$comment."', '".$time."');";
				$command=Yii::app()->db->createCommand($sql);
				$command->execute();
				$id = Yii::app()->db->getLastInsertID();
			}
			
			if ($error == 0)
			{
				echo "<script>$('#mym').empty();</script>";
				echo '<script>
				
				var a = \'<form enctype="multipart/form-data" action="/ajax/addaction/" method="POST" id="actionForm" class="">\';
				
				a += \'<div class="action_label"><h3>ШАГ 2 из 2.</h3></div>\';
				
				a += \'<div class="action_label">Необходимо загрузить 4-е фотографии процесса шитья изделия на разных этапах, а также фото готовой работы (спереди и сзади) и фото оставшейся комплектации. Необходимо загружать фотографии в удобном для просмотра виде (повёрнутые)!</div>\';
				
				a += \'<div class="action_label action_load">Выберите тип фото: <select id="select_id" style="width:200px;"><option value="0">Выбрать...</option><option value="1">Раскрой игрушки</option><option value="2">Сшивание</option><option value="3">Выворачивание и набивание</option><option value="4">Сборка и декорирование</option><option value="5">Фото готовой работы спереди</option><option value="6">Фото готовой работы сзади</option><option value="7">Фото оставшейся комплектации</option></select></div>\';
				
				a += \'<div class="action_label action_load">Выберите фото для загрузки: <input id="uploadImage" type="file" accept="image/*" name="image"></div>\';
				
				a += \'<div class="action_label action_load"><input type="submit" class="" id="load_act" value=""></div>\';
				
				a += \'<div class="action_label"><div id="foto_act"><ul><li id="li_act_1">\';
				a += \'<a rel="lytebox" onclick="myLytebox.start(this); return false;" id="hr_foto_act_1" href="/src/img/opacity.png" target="_blank"><img id="foto_act_1" src="/src/img/opacity.png"></a>\';
				a += \'<p onclick="li_act_none(1);">Удалить</p></li><li id="li_act_2">\';
				a += \'<a rel="lytebox" onclick="myLytebox.start(this); return false;" id="hr_foto_act_2" href="/src/img/opacity.png" target="_blank"><img id="foto_act_2" src="/src/img/opacity.png"></a>\';
				a += \'<p onclick="li_act_none(2);">Удалить</p></li><li id="li_act_3">\';
				a += \'<a rel="lytebox" onclick="myLytebox.start(this); return false;" id="hr_foto_act_3" href="/src/img/opacity.png" target="_blank"><img id="foto_act_3" src="/src/img/opacity.png"></a>\';
				a += \'<p onclick="li_act_none(3);">Удалить</p></li><li id="li_act_4">\';
				a += \'<a rel="lytebox" onclick="myLytebox.start(this); return false;" id="hr_foto_act_4" href="/src/img/opacity.png" target="_blank"><img id="foto_act_4" src="/src/img/opacity.png"></a>\';
				a += \'<p onclick="li_act_none(4);">Удалить</p></li><li id="li_act_5">\';
				a += \'<a rel="lytebox" onclick="myLytebox.start(this); return false;" id="hr_foto_act_5" href="/src/img/opacity.png" target="_blank"><img id="foto_act_5" src="/src/img/opacity.png"></a>\';
				a += \'<p onclick="li_act_none(5);">Удалить</p></li><li id="li_act_6">\';
				a += \'<a rel="lytebox" onclick="myLytebox.start(this); return false;" id="hr_foto_act_6" href="/src/img/opacity.png" target="_blank"><img id="foto_act_6" src="/src/img/opacity.png"></a>\';
				a += \'<p onclick="li_act_none(6);">Удалить</p></li><li id="li_act_7">\';
				a += \'<a rel="lytebox" onclick="myLytebox.start(this); return false;" id="hr_foto_act_7" href="/src/img/opacity.png" target="_blank"><img id="foto_act_7" src="/src/img/opacity.png"></a>\';
				a += \'<p onclick="li_act_none(7);">Удалить</p></li></ul></div></div>\';
				
				
				a += \'<input name="idgood_act" id="idgood_act" type="hidden" value="'.$idgood_act.'">\';
				a += \'<input name="idcomment" id="idcomment" type="hidden" value="'.$id.'">\';
				
				a += \'<div id="results_act"></div>\';
				
				a += \'<img style="display:none; float:right;" id="loader_act" src="/src/img/loader.gif" alt="Loading...." title="Loading...." />\';
				
				a += \'</form>\';
				
				
				a += \'<form enctype="multipart/form-data" action="/ajax/addaction/" method="POST" id="actionFormEnd" class="">\';
				a += \'<div class="both"></div><div class="action_label action_save" style="display:none;"><span style="color:green;">Спасибо, все фотографии загружены, нажмите кнопку «Сохранить»</span></div>\';
				a += \'<div class="action_label action_save" style="display:none;"><input type="submit" class="" name="save_act" id="save_act" value=""></div>\';
				a += \'<input name="idgood_act" id="idgood_act" type="hidden" value="'.$idgood_act.'">\';
				a += \'<input name="idcomment" id="idcomment" type="hidden" value="'.$id.'">\';
				a += \'</form>\';
				
								
				$("#mym").append(a);

				</script>';
				
				
				echo '<script>
					$("#actionForm").submit(function (event) {
					$("#results_act").empty(); 
					event.preventDefault(); 
					var data = new FormData($("#actionForm")[0]); 
					data.append("flag","1");
					data.append("idgood_act",'.$idgood_act.');
					data.append("idcomment",$("#idcomment").val());
					data.append("sellc",$("select#select_id").val());
					$.ajax({type: "POST",url: "/ajax/addaction/",data: data,contentType: false,processData: false,cache: false,beforeSend: function() {$("#loader_act").show();}}).done(function (html) {$("#results_act").empty();$("#results_act").append(html);$("#loader_act").hide(); });});
				</script>';
				
				echo '<script>
					$("#actionFormEnd").submit(function (event) {
					$("#results_act").empty(); 
					event.preventDefault(); 
					var data = new FormData($("#actionFormEnd")[0]); 
					data.append("flag","1");
					data.append("save_act","1");
					data.append("idgood_act",'.$idgood_act.');
					data.append("idcomment",$("#idcomment").val());
					data.append("sellc",$("select#select_id").val());
					$.ajax({type: "POST",url: "/ajax/addaction/",data: data,contentType: false,processData: false,cache: false,beforeSend: function() {$("#loader_act").show();}}).done(function (html) {$("#results_act").empty();$("#results_act").append(html);$("#loader_act").hide(); });});
				</script>';
			}
			
		}
		else {
			if (!isset($_POST['idgood'])) throw new CHttpException(404,'The requested page does not exist.');
			$idgood = $_POST['idgood'];
			if (isset($_SESSION['name_comment'])) $name_comment=$_SESSION['name_comment']; else $name_comment = "";
			if (isset($_SESSION['email_comment'])) $email_comment=$_SESSION['email_comment']; else $email_comment = "";
			echo '
			
				<div class="opacity_action"><div id="action_block"><div id="action_cont">
				<img onclick="$(\'.opacity_action\').remove();" src="/src/img/opac-close.png">
				<div class="action_title">Первому сшившему набор – подарок!</div>
				
				<div id="mym">
				<form enctype="multipart/form-data" action="/ajax/addaction/" method="POST" id="actionForm" class="">
					<div id="results_act"></div>
					<input name="idgood_act" id="idgood_act" type="hidden" value="'.$idgood.'">
					<div class="action_label"><h3>ШАГ 1 из 2.</h3></div>
					<div class="action_label">&nbsp;&nbsp;Ваше имя: <input type="text" name="a1" id="a1" value="'.$name_comment.'" class="action-inp"><span style="color:red;" id="er_a1"></span></div>
					<div class="action_label">Ваш e-mail: <input type="text" name="a2" id="a2" value="'.$email_comment.'" class="action-inp"><span style="color:red;" id="er_a2"></span></div>
					<div class="action_label">
						<b>Ответьте на обязательные вопросы, оцените новинку, напишите о ваших впечатлениях от набора.</b>
						<br />Список обязательных вопросов для первого сшившего набор:
						<br /> 1. Полностью ли укомплектован набор?
						<br /> 2. Хватило ли вложенных материалов?
						<br /> 3. Не было ли неточностей или ошибок в выкройке или инструкции?
						<br /> 4. Понятна ли выкройка и инструкция?
						<br /> 5. Устроило ли качество входящих в набор материалов?
						<textarea rows="5" name="a3" id="a3" value="" class="action_area"></textarea>
					</div>
					<div class="action_label">На следующем шаге загрузка фотографий (<a target="_blank" href="/action/">подробнее об акции<a>)</div>
					<div class="action_label"><span style="color:red;" id="er_a3"></span></div>
					<div class="action_send"><input type="submit" class="action-sub" value=""></div>
					<img style="display:none; float:left;" id="loader_act" src="/src/img/loader.gif" alt="Loading...." title="Loading...." />
				
					<script>
						$("#actionForm").submit(function (event) {$("#results_act").empty();
						event.preventDefault();
						var data = new FormData($("#actionForm")[0]); 
						data.append("a1",$("#a1").val()); 
						data.append("a2",$("#a2").val()); 
						data.append("a3",$("#a3").val());
						data.append("idgood_act",$("#idgood_act").val());
						$.ajax({type: "POST",url: "/ajax/addaction/",data: data,contentType: false,processData: false,cache: false,beforeSend: function() {$("#loader_act").show();}}).done(function (html) {$("#results_act").empty();$("#results_act").append(html);$("#loader_act").hide(); });});
					</script>
							
				</form>
				</div>
				
				
				</div></div></div>';
			
			echo '';
			
		}
	}
	
	public function actionExpect()
	{
		if (!isset($_POST['y1'])) throw new CHttpException(404,'The requested page does not exist.');
		if ( (isset($_POST['y1'])) && (isset($_POST['y2'])) )
		{
			echo "<script>$('#er_y1').empty();</script>";
			if ((strlen($_POST['y1']) >= 0) && (strlen($_POST['y1']) < 100) )
			{
				if (!preg_match("/^([a-zA-Z0-9_\.-]+)@([a-zA-Z0-9_\.-]+)\.([a-zA-Z\.]{2,6})$/", $_POST['y1'])) {echo "<script>$('#er_y1').append('<br />неверный e-mail')</script>"; exit();}
			
				echo "<script>$('#on_y1').empty();</script>";
				echo "<script>$('#ok_y1').append('<br />Спасибо! E-mail сохранен.')</script>";
				
				$email = $_POST['y1'];
				$idgood = $_POST['y2'];
				
				$sql = "INSERT INTO {{expect}} (id, email, idgood) VALUES(NULL, '".$email."', '".$idgood."');";
				$command=Yii::app()->db->createCommand($sql);
				$command->execute();
			}
		}
	}
	
	public function actionUploader()
	{
		session_start();
		
		/*$extensions = array('jpeg', 'jpg', 'png', 'gif');
		$max_size = 50000000;
		$path = 'images/';
		$response = '';
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
		  if ($_FILES['image']['size'] > $max_size)
		  {
		    $response = 'File is too large';
		  }
		  else
		  {
		    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
		    if (in_array($ext, $extensions))
		    {
		      $path = $path . uniqid() . '.' . $ext;
		 
		      if (move_uploaded_file($_FILES['image']['tmp_name'], $path))
		      {
		        $response = "<img style='height: 200px' src='$path' />";
		      }
		    }
		    else
		    {
		      $response = 'File must be an image!';
		    }
		  }
		}
		 
		echo $response;
		*/
		//$_POST['parent_id']
		//$_POST['level']
		//$_POST['idadd']
		
		//
		
		if (!isset($_POST['typepage'])) throw new CHttpException(404,'The requested page does not exist.');
		$typepage = 0;
		if ( ($_POST['typepage'] == 5) || ($_POST['typepage'] == 6) )
		{
			$error = 0;
			$_SESSION['name_comment'] = $_POST['s1'];
			$_SESSION['email_comment'] = $_POST['s2'];
			if(isset($_POST['s1']))
			{
				if ($_POST['typepage'] == 6) {
					echo "<script>$('#er_s11').empty();</script>";
					if (strlen($_POST['s1']) == 0) {echo "<script>$('#er_s11').append('&nbsp;введите имя')</script>"; $error++;}
				}
				else {
					$typepage = 5;
					echo "<script>$('#er_s1').empty();</script>";
					if (strlen($_POST['s1']) == 0) {echo "<script>$('#er_s1').append('&nbsp;введите имя')</script>"; $error++;}
				}
			}
			
			if(isset($_POST['s2']))
			{
				if ($_POST['typepage'] == 6) {
					echo "<script>$('#er_s21').empty();</script>";
					if (strlen($_POST['s2']) > 0)
						if (!preg_match("/^([a-zA-Z0-9_\.-]+)@([a-zA-Z0-9_\.-]+)\.([a-zA-Z\.]{2,6})$/", $_POST['s2'])) {echo "<script>$('#er_s21').append('&nbsp;неверный e-mail')</script>"; $error++;}
				}
				else {
					echo "<script>$('#er_s2').empty();</script>";
					if (strlen($_POST['s2']) > 0)
						if (!preg_match("/^([a-zA-Z0-9_\.-]+)@([a-zA-Z0-9_\.-]+)\.([a-zA-Z\.]{2,6})$/", $_POST['s2'])) {echo "<script>$('#er_s2').append('&nbsp;неверный e-mail')</script>"; $error++;}
				}
			}
			
			if(isset($_POST['s3']))
			{
				if ($_POST['typepage'] == 6) {
					echo "<script>$('#er_s31').empty();</script>";
					if ( (strlen($_POST['s3']) == 0) && (strlen($_FILES['image']['tmp_name']) == 0)) {echo "<script>$('#er_s31').append('&nbsp;Выберите фото или напишите комментарий')</script>"; $error++;}
				}
				else {
					echo "<script>$('#er_s3').empty();</script>";
					if ( (strlen($_POST['s3']) == 0) && (strlen($_FILES['image']['name']) == 0) ) {echo "<script>$('#er_s3').append('&nbsp;Выберите фото или напишите комментарий')</script>"; $error++;}
				}
			}
			
			if ( (isset($_POST['s4'])) && (isset($_POST['code'])) )
			{
				if ($_POST['typepage'] == 6) {
					echo "<script>$('#er_s41').empty();</script>";
					if ( strcmp(md5($_POST['s4']),$_POST['code']) !== 0 ) {echo "<script>$('#er_s41').append('&nbsp;Проверочный код неверен')</script>"; $error++;}
				}
				else {
					echo "<script>$('#er_s4').empty();</script>";
					if ( strcmp(md5($_POST['s4']),$_POST['code']) !== 0 ) {echo "<script>$('#er_s4').append('&nbsp;Проверочный код неверен')</script>"; $error++;}
				}
			}
			else {exit('Где-то ошибка!');}
			
			if ($error == 0)
			{
				$margin_px = 0;
				$level = $_POST['level'] + 1;
				$margin_px = 60*$level;
				$name = htmlspecialchars($_POST['s1']);
				$email = htmlspecialchars($_POST['s2']);
				$comment = htmlspecialchars($_POST['s3']);
				$comment = str_replace("'","\"",$comment);
				$name = str_replace("'","\"",$name);
				$time = strtotime("now");
				
				$idgood = $_POST['idgood'];
				
				if ($_POST['typepage'] == 6) {
					$level = 0;
					$margin_px = 0;
				}
				
				$sql = "INSERT INTO {{comment}} (id, parent_id, good_id, name, email, foto, level,comment,time) VALUES(NULL, ".$_POST['idadd'].", '".$idgood."', '".$name."', '".$email."', 0, ".$level.", '".$comment."', '".$time."');";
				$command=Yii::app()->db->createCommand($sql);
				$command->execute();
				$id = Yii::app()->db->getLastInsertID();
				$code_comment = rand(10000, 99999);
				$_SESSION['code_comment'] = $code_comment;
				$foto = 0;
				if(isset($_FILES['image']))
				{
					$foto = 1;
					$pathr=$_SERVER['DOCUMENT_ROOT'].'/images/comment/comm_'.$id.'.jpg';
					$pathr_sm=$_SERVER['DOCUMENT_ROOT'].'/images/comment/comm_'.$id.'_sm.jpg';
					$pathr_orig=$_SERVER['DOCUMENT_ROOT'].'/images/comment/original/comm_'.$id.'.jpg';
					umask(0002);

					$extensions = array('jpeg', 'jpg');
					$response = '';
					$max_size = 1;
					if ( ($_FILES['image']['error'] > 0) && ($_FILES['image']['error'] < 4) )
					{
						$response = 'Размер изображения слишком большой (должно быть не более 4Мб)';
						echo "<script>alert('".$response."');</script>";
						$sql = "DELETE FROM {{comment}} WHERE `id` = ".$id.";";
						$command=Yii::app()->db->createCommand($sql);
						$command->execute();
						exit();
					}
					else {
						$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
						if ($_FILES['image']['error'] == 0)
						if (in_array($ext, $extensions))
						{

							if (!move_uploaded_file($_FILES['image']['tmp_name'],$pathr)) { $foto = 0;/*echo "<script>$('#er_s3').text('Ошибка записи файла')</script>"; exit();*/}
							else {
								$x = 700;
						    	$y_sm = 70;
						    	$y_size = 200;
								$img=imagecreatefromjpeg($pathr);
								$size = getimagesize($pathr);
								
								if ($img)
									if ( ($size[0]<$y_size) || ($size[1]<$y_size) )
									{
										$response = 'Изображение слишком маленькое (должно быть не менее '.$y_size.'px по длине или ширине)';
										echo "<script>alert('".$response."');</script>";
										$sql = "DELETE FROM {{comment}} WHERE `id` = ".$id.";";
										$command=Yii::app()->db->createCommand($sql);
										$command->execute();
										exit();
									}
								
								$sql = "UPDATE {{comment}} SET `foto` = '1' WHERE `id` = ".$id.";";
								$command=Yii::app()->db->createCommand($sql);
								$command->execute();
								
								if ($img)
								{
									if ($size[0]>$x)
									{
										//Ширина изображения больше чем нужно
										$scale=$x/$size[0];
										$y = $size[1] * $scale;
										$target=imagecreatetruecolor($x,$y);
										imagecopyresampled($target,$img,0,0,round(($size[0]-$x/$scale)/2),0,$x,$y,round($x/$scale),$size[1]);
										if (file_exists($pathr)) unlink($pathr);
										imagejpeg($target,$pathr);
									}
									//превью по высоте
									if ($size[1]>$y_sm)
									{
										$scale=$y_sm/$size[1];
										$x = $size[0] * $scale;
										$target=imagecreatetruecolor($x,$y_sm);
										imagecopyresampled($target,$img,0,0,0,round(($size[1]-$y_sm/$scale)/2),$x,$y_sm,$size[0],round($y_sm/$scale));
										imagejpeg($target,$pathr_sm);
									}
									//сохранение оригинала
									if (file_exists($pathr)) copy($pathr, $pathr_orig);
								}
								//watermark
								$logo_file = $_SERVER['DOCUMENT_ROOT']."/src/img/miadolla-logo.png"; 
								$image_file = $pathr; 
								$targetfile = $pathr; 
								$photo = imagecreatefromjpeg($image_file); 
								$fotoW = imagesx($photo); 
								$fotoH = imagesy($photo); 
								$logoImage = imagecreatefrompng($logo_file); 
								$logoW = imagesx($logoImage); 
								$logoH = imagesy($logoImage); 
								$photoFrame = imagecreatetruecolor($fotoW,$fotoH); 
								$dest_x = $fotoW - $logoW; 
								$dest_y = $fotoH - $logoH; 
								imagecopyresampled($photoFrame, $photo, 0, 0, 0, 0, $fotoW, $fotoH, $fotoW, $fotoH); 
								imagecopy($photoFrame, $logoImage, $dest_x, $dest_y, 0, 0, $logoW, $logoH); 
								imagejpeg($photoFrame, $targetfile); 
								
							}
							
						}
						else {
							$response = 'Изображение имеет неверный формат (поддерживаются только в форматах: jpeg, jpg)';
							echo "<script>alert('".$response."');</script>";
						}
					}

				}
				$flag = 0;
				$foto_send = "";
				$tekst = '<div class="comment_tr" style="margin-left:'.$margin_px.'px;"><div class="comment_img">&nbsp;</div><div class="comment_block"><div class="comment_name">'.$name.'</div><div class="comment_data">'.date("d.m.Y, H:i",$time).'</div>';
				$full_path = $_SERVER['DOCUMENT_ROOT'].'/images/comment/comm_'.$id.'.jpg';
				if (file_exists($full_path)) {
					if ($foto == 1) {$foto_send = '<img src="http://miadolla.ru/images/comment/comm_'.$id.'_sm.jpg" alt="">'; $tekst .= '<a rel="lytebox" onclick="myLytebox.start(this); return false;" href="/images/comment/comm_'.$id.'.jpg" target="_blank"><img src="/images/comment/comm_'.$id.'_sm.jpg" alt=""></a>';}
					if ( ($foto == 1) && (strlen($comment) > 0) ) {$tekst .= '<br />';}
				} else {
					if (strlen($comment) == 0) {
						$sql = "DELETE FROM {{comment}} WHERE `id` = ".$id.";";
						$command=Yii::app()->db->createCommand($sql);
						$command->execute();
						$flag = 1;
					}
				}
				$tekst .= '<div class="comment_text">'.$comment.'</div><div class="comment_ans"><a href="#" onclick="mainForm_disp(0,'.$id.'); comm_id('.$id.','.$_POST['parent_id'].','.$level.','.$idgood.'); return false;">Ответить</a></div><div id="comm_'.$id.'"></div></div></div><div id="addcomm_'.$id.'"></div>';
				if ($flag == 0) {
					echo "<script>$('#addcomm_".$_POST['idadd']."').append('".$tekst."');</script>";
					//echo $typepage;
					//echo "<br />";
					//echo $_POST['idadd'];
					//echo "<script>alert('".$typepage."'); alert('".$_POST['idadd']."');</script>";
					//Отправка уведомления пользователю
					if ( ($typepage == 5) && ($_POST['idadd'] > 0) ) {
						$sql = 'select email from {{comment}} where id='.$_POST['idadd'];
						$command=Yii::app()->db->createCommand($sql);
						$r1=$command->query();
						//echo "<script>alert('".$typepage."'); alert('".$_POST['idadd']."'); alert('".$sql."');</script>";
						if (sizeof($r1) == 1)
						{
							foreach($r1 as $s1)
							{
								if (strlen($s1['email']) > 3) {
									$mail_send1 = "";
									//$mail_send1 = "khaziyev_m@sb-service.ru";
									$mail_send2 = $s1['email'];
									
									$headers = "From: Miadolla.Ru <toys@miadolla.ru> \r\n";
									$su='Новый комментарий на Miadolla.Ru';
									$su = iconv("utf-8", "windows-1251", $su);
									$subj ='=?windows-1251?B?'.base64_encode($su).'?=';
									$headers.= "Content-Type: text/html; charset=Windows-1251\r\n";
									$headers.= "MIME-Version: 1.0\r\n";
									
									$mailbody ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
										<html>
										<head>
										<title>miadolla.ru - комментарий на сайте</title>
										<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
										</head>
										<style>
										h1{font-family:Arial, Helvetica, sans-serif;font-size:16px;font-weight:bold;}
										h2{font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;}
										p{font-family:Arial, Helvetica, sans-serif;font-size:12px;}
										</style>
										<body>
										<h1>Новый комментарий на сайте Miadolla.Ru</h1>
										<p>На сайте Miadolla.Ru написан ответ на Ваш комментарий <a href="http://miadolla.ru/catalog/good_'.$idgood.'" target="_blank">к набору</a></p>
										<p><b>Дата и время:</b> '.date("d.m.Y, H:i",$time).'</p>';
										/*if (strlen($email) > 0) $mailbody .='<p><b>E-mail:</b> '.$email.'</p>';*/
										$mailbody .= '<p><b>Комментарий:</b> '.$foto_send.$comment.'</p>
										</body>
										</html>';
									
									$mailbody = iconv("utf-8", "windows-1251", $mailbody);
									$headers = iconv("utf-8", "windows-1251", $headers);
									//mail($mail_send1, $subj, $mailbody, $headers);
									$pos = strpos($mail_send2, "toys@miadolla.ru");
									if ($pos === false)
										mail($mail_send2, $subj, $mailbody, $headers);
								}
							}
						}
					}

					$mail_send1 = "khaziyev_m@sb-service.ru";
					//$mail_send2 = "";
					$mail_send2 = "toys@miadolla.ru";
					
					$headers = "From: Miadolla.Ru <toys@miadolla.ru> \r\n";
					$su='Новый комментарий на Miadolla.Ru';
					$su = iconv("utf-8", "windows-1251", $su);
					$subj ='=?windows-1251?B?'.base64_encode($su).'?=';
					$headers.= "Content-Type: text/html; charset=Windows-1251\r\n";
					$headers.= "MIME-Version: 1.0\r\n";
					
					$mailbody ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
						<html>
						<head>
						<title>miadolla.ru - комментарий на сайте</title>
						<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
						</head>
						<style>
						h1{font-family:Arial, Helvetica, sans-serif;font-size:16px;font-weight:bold;}
						h2{font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;}
						p{font-family:Arial, Helvetica, sans-serif;font-size:12px;}
						</style>
						<body>
						<h1>Новый комментарий на сайте Miadolla.Ru</h1>
						<p>На сайте Miadolla.Ru новый комментарий <a href="http://miadolla.ru/catalog/good_'.$idgood.'" target="_blank">к набору</a></p>
						<p><b>Дата и время:</b> '.date("d.m.Y, H:i",$time).'</p>';
						if (strlen($email) > 0) $mailbody .='<p><b>E-mail:</b> '.$email.'</p>';
						$mailbody .= '<p><b>Комментарий:</b> '.$foto_send.$comment.'</p>
						<p><a href="http://www.miadolla.ru/admin/" target="_blank">Панель управления</a></p>
						</body>
						</html>';
					
					$mailbody = iconv("utf-8", "windows-1251", $mailbody);
					$headers = iconv("utf-8", "windows-1251", $headers);
					mail($mail_send1, $subj, $mailbody, $headers);
					mail($mail_send2, $subj, $mailbody, $headers);
				}
				echo "<script>$('.mainForm').remove(); mainForm_disp(1,'.$id.');</script>";
				echo "<script>$('#s31').val('');</script>";
				echo "<script>$('#s41').val('');</script>";
				if ($_POST['typepage'] == 6) echo "<script>location.reload();</script>";
			}
			
			exit();
		}

		
		$id = 0;
		$randnum = rand();
		umask(0002);
		if(isset($_POST['idpage'])) $id = $_POST['idpage'];
		
		if ( ($_POST['typepage'] == 1) || ($_POST['typepage'] == 2) )
		{
			if(!is_dir($_SERVER['DOCUMENT_ROOT']."/images/news/".$id."/")) $new_dir = mkdir ($_SERVER['DOCUMENT_ROOT']."/images/news/".$id."/", 0777);
		}
		elseif ($_POST['typepage'] == 3)
		{
			if(!is_dir($_SERVER['DOCUMENT_ROOT']."/images/mc/".$id."/")) $new_dir = mkdir ($_SERVER['DOCUMENT_ROOT']."/images/mc/".$id."/", 0777);
		}	
		elseif ($_POST['typepage'] == 4)
		{
			if(!is_dir($_SERVER['DOCUMENT_ROOT']."/images/articles/".$id."/")) $new_dir = mkdir ($_SERVER['DOCUMENT_ROOT']."/images/articles/".$id."/", 0777);
		}

		if(isset($_FILES['image']))
		{
			if ($_POST['typepage'] == 1) $pathr=$_SERVER['DOCUMENT_ROOT'].'/images/news/'.$id.'/news_smin_'.$id.'.tmp.jpg';
			if ($_POST['typepage'] == 2) $pathr=$_SERVER['DOCUMENT_ROOT'].'/images/news/'.$id.'/news_small_'.$id.'.tmp.jpg';
			if ($_POST['typepage'] == 3) $pathr=$_SERVER['DOCUMENT_ROOT'].'/images/mc/'.$id.'/mc_small_'.$id.'.tmp.jpg';
			if ($_POST['typepage'] == 4) $pathr=$_SERVER['DOCUMENT_ROOT'].'/images/articles/'.$id.'/articles_small_'.$id.'.tmp.jpg';
			if (!move_uploaded_file($_FILES['image']['tmp_name'],$pathr)) {echo "Ошибка записи файла"; exit();}
		}

		$url_konkurs = 0;

		$im=imagecreatefromjpeg($pathr);	
		$w_src = imagesx($im);
		$h_src = imagesy($im);		

		imagedestroy($im);

		//настройка редактора
		$type_load = 0;
		$crop_style = "crop_img_src_440";
		$crop_style_pr = "crop_img_pr_440";
		$src_width = 440;
		$margin_left = 450;
		$scale = 1;
		if ($w_src<$src_width) {$src_width = $w_src; $margin_left = $w_src+10;}
		elseif ($w_src>$src_width) {$scale = $src_width / $w_src;}

		
		if(isset($_POST['typepage'])) 
		{
			if ($_POST['typepage'] == 1)
			{
				$type_load = $_POST['typepage'];
				
				$preview_size = "[195, 50]";
				$size_w = 195;
				$size_h = 0;
				$aspectRatio = 0;
				$previewBoundary = 80;
				$selectionPosition = "[0, 0]";
				$selectionWidth = 195;
				$selectionHeight = 50;
				
				$nameimg = "smin";
				
				$file_preview = "/images/news/".$id."/news_".$nameimg."_".$id.".tmp.jpg";
				$file_preview_thumb = "/images/news/".$id."/news_".$nameimg."_".$id;
			}
			elseif ($_POST['typepage'] == 2)
			{
				$type_load = $_POST['typepage'];
				
				$preview_size = "[100, 100]";
				$size_w = 100;
				$size_h = 100;
				$aspectRatio = 1;
				$previewBoundary = 80;
				$selectionPosition = "[0, 0]";
				$selectionWidth = 100;
				$selectionHeight = 100;
				
				$nameimg = "small";
				
				$file_preview = "/images/news/".$id."/news_".$nameimg."_".$id.".tmp.jpg";
				$file_preview_thumb = "/images/news/".$id."/news_".$nameimg."_".$id;
			}
			elseif ($_POST['typepage'] == 3)
			{
				$type_load = $_POST['typepage'];
				
				$preview_size = "[165, 165]";
				$size_w = 165;
				$size_h = 165;
				$aspectRatio = 1;
				$previewBoundary = 80;
				$selectionPosition = "[0, 0]";
				$selectionWidth = 165;
				$selectionHeight = 165;
				$nameimg = "small";
				
				$file_preview = "/images/mc/".$id."/mc_".$nameimg."_".$id.".tmp.jpg";
				$file_preview_thumb = "/images/mc/".$id."/mc_".$nameimg."_".$id;
			}
			elseif ($_POST['typepage'] == 4)
			{
				$type_load = $_POST['typepage'];
				
				$preview_size = "[105, 105]";
				$size_w = 105;
				$size_h = 105;
				$aspectRatio = 1;
				$previewBoundary = 80;
				$selectionPosition = "[0, 0]";
				$selectionWidth = 105;
				$selectionHeight = 105;
				$nameimg = "small";
				
				$file_preview = "/images/articles/".$id."/articles_".$nameimg."_".$id.".tmp.jpg";
				$file_preview_thumb = "/images/articles/".$id."/articles_".$nameimg."_".$id;
			}
			else exit('Нет номера загрузки!');
		}

				echo '
				<div id="scr_foto'.$type_load.'">
						<script type="text/javascript">
						$(document).ready(function() {
							$("img#example").imageCrop({
								displayPreview : false,
								displaySize : true,
								aspectRatio : '.$aspectRatio.',
								overlayOpacity : 0.55,
								minSize : '.$preview_size.',
								imgSizeCrop: '.$src_width.',
								scale: '.$scale.',
								previewBoundary : '.$previewBoundary.',
								selectionPosition : '.$selectionPosition.',
							    selectionWidth : '.$selectionWidth.',
							    selectionHeight : '.$selectionHeight.',
								onSelect : updateForm
							});				
						});
						
						var selectionExists;
	
						// Update form inputs
						function updateForm(crop) {
							$("input#x").val(crop.selectionX);
							$("input#y").val(crop.selectionY);
							$("input#width").val(crop.selectionWidth);
							$("input#height").val(crop.selectionHeight);
			
							selectionExists = crop.selectionExists();
						};
			
						// Validate form data
						function validateForm() {
							if (selectionExists)
								return true;
							alert("Please make a selection first!");
							return false;
						};			
						</script>
				
						<style type="text/css">
							#crop_img_src_600{position: relative; width: 600px; flloat: left;}
							#crop_img_pr_600{position: absolute; z-index:1; margin-left: '.$margin_left.'px; }
							#crop_img_src_440{position: relative; width: 440px; flloat: left;}
							#crop_img_pr_440{position: absolute; margin-left: '.$margin_left.'px; z-index: 1;}
						</style>';

					if ( ($type_load == 1) || ($type_load == 3) || ($type_load == 4) )
						echo '<script type="text/javascript">
							function selClickCrop() {
								$("#div_crop'.$type_load.'").html("Загрузка...");
								$("#div_crop'.$type_load.'").load("/ajax/crop/", {"type_load":'.$type_load.',"url_konkurs":"'.$url_konkurs.'", "size_w":'.$size_w.', "size_h":'.$size_h.', "scale":'.$scale.', "src_width":'.$src_width.', "name_file":"'.$file_preview.'", "name_file_thumb":"'.$file_preview_thumb.'", "id":'.$id.', "uid":'.$id.', "idfoto":'.$id.', "x":document.getElementById("x").value, "y":document.getElementById("y").value, "width":document.getElementById("width").value, "height":document.getElementById("height").value});
								$("#fotowork'.$type_load.'").css("display", "none");
								}
						</script>';
					elseif ($type_load == 2)
						echo '<script type="text/javascript">
							function selClickCrop() {
								$("#div_crop'.$type_load.'").html("Загрузка...");
								$("#div_crop'.$type_load.'").load("/ajax/crop/", {"type_load":'.$type_load.',"url_konkurs":"'.$url_konkurs.'", "size_w":'.$size_w.', "size_h":'.$size_h.', "scale":'.$scale.', "src_width":'.$src_width.', "name_file":"'.$file_preview.'", "name_file_thumb":"'.$file_preview_thumb.'", "id":'.$id.', "uid":'.$id.', "idfoto":'.$id.', "x":document.getElementById("x").value, "y":document.getElementById("y").value, "width":document.getElementById("width").value, "height":document.getElementById("height").value});
								$("#fotowork'.$type_load.'").css("display", "none");
								}
						</script>';
					else exit();
				echo "</div>";
							
				echo '<div id="form" style="width: 500px;">
							<div id="fotowork'.$type_load.'">
							<a name="load"></a>
								<p><b>Выберите область и кликните 2раза для сохранения!</b></p>
								<div id="'.$crop_style.'">
									<img style="max-width:'.$src_width.'px;" alt="" id="example" src="'.$file_preview.'?d='.$randnum.'" />
								</div>
								<input id="x" name="x" type="hidden" value="0" />
								<input id="y" name="y" type="hidden" value="0" />
								<input id="width" name="width" type="hidden" value="0" />
								<input id="height" name="height" type="hidden" value="0" />
							</div>
							<div id="div_crop'.$type_load.'"></div>
						</div>';		

	}
	
public function actionGetdelivery()
	{
		if (!isset($_GET['id'])) die();//('No ID');
		if(preg_match('/\D/', $_GET['id'])) die();//('BrockenID');
		session_start();
		//require_once($_SERVER['DOCUMENT_ROOT'].'/includes/ajax_functions.php');
		//require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
		//require_once(CONF_ROOT.'/includes/db.php');
		//                0       1      2         3         4         5            6       7
		$sql = 'SELECT iddeliv,idcity,delivtype,delivtime,delivname,delivaddress,defcost,speccode FROM leo_delivery WHERE idcity='.$_GET['id'];
		//if ($DB->NumRows($s)==0) die();//('No specdeliv'.$DB->Statistic());
		
		$command=Yii::app()->db->createCommand($sql);
		$s=$command->query();
		if (sizeof($s) == 0) die();
		
		//while ($r=$DB->GetRow($s))
		foreach($s as $r)
		{
			if ($r['delivtype']==1)
			{  //Доставка боксбери курьером
			
			}
			
			if ($r['delivtype']==5)
			{
				$iddeliv = $r['iddeliv'];
				$delivtime = $r['delivtime'];
				$Code = 'c5';
				$price = 0;
				
				$soap = new SoapClient('http://is.topdelivery.ru/api/soap/w/1.2/?WSDL', array('login'=>"tdsoap",'password'=>"fc7a00f11c1bfa9f5b69e0be9117738e"));
				$speccode = explode("-", $r['speccode']);
				$regionId = $speccode[0];
				$cityId = $speccode[1];
				
				$params1 = array(
				    'getPickupAddresses'=>array(
				       'auth'=>array(
				            'login'=>'igla',
				            'password'=>'KASZbCMIBtba',
				        ),
				        'regionId'=>$regionId,
				        'cityId'=>$cityId,
				    ),
				);
				$data1 = $soap->__call( 'getPickupAddresses', $params1);
				$citiall = array();
				if ($data1->requestResult->status == 0) {
					if (isset($data1->regionCitiesPickup->citiesPickup)) {
						$z1=$data1->regionCitiesPickup->citiesPickup;
						if (!is_array($z1))$z[]=$z1;
						else $z=$z1;
						foreach ($z AS $k1 => $v1)
						{
							$cityName=$v1->cityName;
							if ($cityId == $v1->cityId) {
								if (!is_array($v1->pickupAddresses))$zz[]=$v1->pickupAddresses;
								else $zz=$v1->pickupAddresses;
								foreach($zz AS $k2 => $v2)
								{
									$cityAddress=$v2->address;
									$citiall[$v2->id] = "г.".$cityName.", ".$cityAddress;
								}
							}
						}
					}
				}
				
				//Пункт выдачи заказов Top Delivery
				foreach ($citiall AS $key=>$val) {
					//echo $key.' '.$val;
					//echo "<br />";
					
					//Стоимость доставки
					$params = array(
					    'calcOrderCosts'=>array(
					       'auth'=>array(
					            'login'=>'igla',
					            'password'=>'KASZbCMIBtba',
					        ),
					     'orderParams'=>array(
					                'serviceType' =>'DELIVERY',
					                'deliveryType' =>'PICKUP',
					                'deliveryWeight' => array(
					                    
					                ),
					                
					                'deliveryAddress' =>array(
					                    'region' => $speccode[0],
					                    'city' => $speccode[1],
					                    'type'=>'id',
					                ),
					            ),
					    ),
					);
					$data = $soap->__call( 'calcOrderCosts', $params);
					if ($data->requestResult->status == 0) {
						$price = $data->calcOrderCosts->delivery;
					
						echo '<label class="radio specdeliv specdelivcode" style="display: block;"> <input type="radio" name="type_arrive" class="delivery_select" required="" value="'.$iddeliv.'" data-val="'.$key.'"> <b>Пункт выдачи заказов Top Delivery - <span style="color:#a23520;">'.$price.' руб.</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: ';
						echo $delivtime; echo ')';
						//echo $r['speccode'];
						echo '<br>'.$val;
						echo '</span> </label>';
					}
					
				}
					
				//Доставка курьером Top Delivery	
				$params = array(
				    'calcOrderCosts'=>array(
				       'auth'=>array(
				            'login'=>'igla',
				            'password'=>'KASZbCMIBtba',
				        ),
				     'orderParams'=>array(
				                'serviceType' =>'DELIVERY',
				                'deliveryType' =>'COURIER',
				                'deliveryWeight' => array(
				                    
				                ),
				                
				                'deliveryAddress' =>array(
				                    'region' => $speccode[0],
				                    'city' => $speccode[1],
				                    'type'=>'id',
				                ),
				            ),
				    ),
				);
				$data = $soap->__call( 'calcOrderCosts', $params);
				if ($data->requestResult->status == 0) {
					$price = $data->calcOrderCosts->delivery;
				
					echo '<label class="radio specdeliv specdelivcode" style="display: block;"> <input type="radio" name="type_arrive" class="delivery_select" required="" value="'.$iddeliv.'" data-val="'.$Code.'"> <b>Доставка курьером Top Delivery - <span style="color:#a23520;">'.$price.' руб.</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: ';
					echo $delivtime;
					echo ')';
					//echo $r['speccode'];
					echo '</span> </label>';
				}
				
			}

			/*
			if ($r['delivtype']==2)
			{  //Доставка боксбери ПВЗ
				$url='http://api.boxberry.de/json.php?token=11656.rzpqafcd&method=ListPoints&CityCode='.$r['speccode'];
				$handle = fopen($url, "rb");
				$contents = stream_get_contents($handle);
				fclose($handle);
				//$pvz[0]['err'] = false;
				$pvz=json_decode($contents,true);
				if(count($pvz)<=0 or ( (isset($pvz[0]['err'])) && $pvz[0]['err'] ))
				{
					// если произошла ошибка и ответ не был получен
					//echo $pvz[0]['err'];
					continue;
				}
				else
				{
					// все отлично, ответ получен, теперь в массиве $data
					//Стоимость доставки для всех ПВЗ города одна, запросим стоимость 1 раз
					//Вес в граммах предположим 500
					$url='http://api.boxberry.de/json.php?token=11656.rzpqafcd&method=DeliveryCosts&weight=1000&target='.$pvz[0]['Code'].'&ordersum=0&deliverysum=0&paysum=0';
					
					$handle = fopen($url, "rb");
					$contents = stream_get_contents($handle);
					fclose($handle);
					$price=json_decode($contents,true);
					if(count($price)<=0 or ( (isset($price[0]['err'])) && $price[0]['err'] ))
					{
						return;//без стоимости не будем гадать
					}
					$arr = array();
					foreach ($pvz AS $key=>$val)
					{
						if (!in_array($val['Code'], $arr)) {
							$arr[] = $val['Code'];
							if ($price['price'] > 2) {
								echo '<label class="radio specdeliv specdelivcode" style="display: block;"> <input type="radio" name="type_arrive" class="delivery_select" required="" value="'.$r['iddeliv'].'" data-val="'.$val['Code'].'"> <b>Пункт выдачи Boxberry - <span style="color:#a23520;">'.$price['price'].' руб.</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: ';
								echo ($val['DeliveryPeriod']+2).' дня';
								echo ')';
								echo '<br>'.$val['Name'].' '.$val['Address'];
								echo '</span> </label>';
							}
						}				
					}
					$price['price'] = $price['price'] + 159;
					$iddeliv = $r['iddeliv'];
					$Code = 'c4';
					if ($iddeliv != 1103) {
						if ($price['price'] > 2) {
							echo '<label class="radio specdeliv specdelivcode" style="display: block;"> <input type="radio" name="type_arrive" class="delivery_select" required="" value="'.$iddeliv.'" data-val="'.$Code.'"> <b>Доставка курьером Boxberry - <span style="color:#a23520;">'.$price['price'].' руб.</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: ';
							echo ($val['DeliveryPeriod']+2).' дня';
							echo ')';
							echo '</span> </label>';
						}
					}
				}
			
			}*/
			
			
		}
	}
	
}
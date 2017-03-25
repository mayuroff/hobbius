<?php
	session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
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
   
        //$outfile_path = $_SERVER['DOCUMENT_ROOT']."/images/prepics/mclass999.jpg";
        $outfile_path = $_POST['name_file_thumb'];
        $outfile_path_thumb = $outfile_path."_thumb.jpg";
        $outfile_path = $outfile_path."_main.jpg";

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
        
        if (isset($_SESSION['bl']))
		{
			$idget="id";
			if (strcmp($_SESSION['bl'],"mklass") === 0) $type_razd="mklass";
			elseif (strcmp($_SESSION['bl'],"news") === 0) $type_razd="news";
			elseif (strcmp($_SESSION['bl'],"articles") === 0) $type_razd="articles";
			elseif (strcmp($_SESSION['bl'],"tree") === 0) {$type_razd="tree"; $idget="treeid";}
			elseif (strcmp($_SESSION['bl'],"konkurs") === 0) {$type_razd="konkurs";}
			else die('�� ����������� ��� �������');
		}
		else die('������ �� �����');
        
        if ($_POST['type_load'] == 0) echo "<p><a href='admin.php?bl=".$type_razd."&act=loadpreviewthumb&".$idget."=".$_POST['id']."'>���������</a></p>";
        elseif ($_POST['type_load'] == 1) echo "<p><a href='admin.php?bl=".$type_razd."&act=loadheaderthumb&".$idget."=".$_POST['id']."'>���������</a></p>";
        elseif ($_POST['type_load'] == 2) {
        	$url_konkurs = $_POST['url_konkurs'];
			echo '<div style="color:green; font-size:16px;">���������!</div><br />';
			echo '
			<script type="text/javascript">
			var text = "/images/konkurs/work_process/j'.$_POST['uid'].'/f_'.$_POST['idfoto'].'_thumb.jpg";
			$("#selectfoto").attr("src", text);
			$("#selectfile").css("display", "block");
			</script>';
			
			$file_th=$_SERVER['DOCUMENT_ROOT']."/images/konkurs/work_process/j".$_POST['uid']."/f_".$_POST['idfoto']."_th.jpg";
			if (file_exists($file_th)) unlink($file_th);
        }
    	elseif ($_POST['type_load'] == 3) {
        	$url_konkurs = $_POST['url_konkurs'];
        	echo "<p><a href='admin.php?bl=".$type_razd.$url_konkurs."&act=loadworkmain#foto'>���������</a></p>";
        }
    }
?>
<?php

if ($code == 404)
{
	echo "
	<link rel=\"stylesheet\" type=\"text/css\" href=\"/src/css/404.css\" />
	<div class=\"header404\">
		<div class=\"htext404\">Запрашиваемая страница<br/>на сайте отсутствует</div>
		<div class=\"himg404\"><img src=\"/src/img/error/404.png\" alt=\"404\" /></div>
	</div>
	<div class=\"main404\">
	<div class=\"page404\">
		<p><strong>Возможные причины, по которым возникла эта ошибка:</strong></p>
		<ul>
			<li><strong>Неправильно указан адрес страницы.</strong><br/>Проверьте правильность набора адреса страницы в адресной строке браузера.</li>
			<li><strong>Эта страница была удалена с сервера либо перемещена по другому адресу.</strong><br/>Попробуйте найти интересующий документ, используя навигацию по разделам сайта.</li>
			<li><strong>".CHtml::encode($message)."</li>
		</ul>
		<p>	<a href=\"/\" class=\"return_link404\">Вернуться на главную</a></p>
								
	</div>
	</div>
	
	<div class=\"footer404\"></div>
	";
	
	
	$request = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$poz_index = strrpos($request, "index.php");
	//if ($poz_index !== false) 
	//{
		//вычисляем текущее время
		$times = strtotime("now");
		$sql = 'INSERT INTO {{error404}} (id, urlpage, time) VALUES (NULL, "'.$request.'", '.$times.');';
		Yii::app()->db->createCommand($sql)->execute();
	//}
	
}
else
{
	echo "<h2>Error ".$code."</h2>
		<div class=\"error\">
		".CHtml::encode($message)."
		</div>";
	
	$su='Информация miadolla';
	$su = iconv("utf-8", "windows-1251", $su);
	$subj ='=?windows-1251?B?'.base64_encode($su).'?=';
	$headers = "From: Miadolla.Ru <shop@igla.ru> \r\n";
	$headers.= "Content-Type: text/html; charset=Windows-1251\r\n";
	$headers.= "MIME-Version: 1.0\r\n";
	mail("khaziyev_m@sb-service.ru", $subj, "New error miadolla", $headers);
}
?>




<?php
{
			$addtxt = '<div class="wrapper wrapper_top"><h1>Обратная связь</h1><div class="contact_form">';
			$error = 0;
			$flag = 0;
			$error_text_code = "";
			$error_text_reason = "";
			
			if (!isset($_POST['filform'])){
				$_SESSION['check_code']=rand(11111,99999);
			}
			
			if (isset($_POST['filform'])) {
				
				//$error++;
				//проверки итд
				$error_text_code = "";
				if ((!isset($_POST['code'])) || ($_POST['code']=='') || ($_SESSION['check_code']!=$_POST['code'])) 
				{$error_text_code = '<br /><span style="color:red;">Неверный проверочный код!</span><br />'; $error++;}
				
				if ($_POST['reason'] == 0) {
					$error_text_reason = '<br /><span style="color:red;">Выберите причину обращения!</span><br />';
					$error++;
				}
				
				if ($error != 0) {
					//echo $error;
				} else {
					
					$to = 'khaziyev_m@sb-service.ru';
					$to1 = 'ryzhov_a@sb-service.ru';
					
					$to2 = 'picture@freya-crystal.ru';
					$to3 = 'picture@freya-crystal.ru';
					
					$headers = "From: Freya-crystal.RU <otvetanet@freya-crystal.ru>\n";
					$su="Новое сообщение в обратной связи";
					$su = iconv("utf-8", "windows-1251", $su);
					$subj ='=?windows-1251?B?'.base64_encode($su).'?=';
					
					
					
					$headers.= "Content-Type: text/html; charset=Windows-1251";
					$mailbody="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\">
					<html><head></head><style>h1{font-family:Arial, Helvetica, sans-serif;
					font-size:16px;font-weight:bold;}
					h3	{font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;color:#000000;}
					p	{font-family:Geneva, Arial, Helvetica, sans-serif;font-size:13px;}
					.io	{font-family:Geneva, Arial, Helvetica, sans-serif;font-size:12px;color:#000000;}
					</style><body>
					<h3>Новое сообщение в обратной связи Freya-crystal.RU</h3>";
					
					$mailbody.="<p class=io><b>Имя:</b> {$_POST['name']}</p>";
					$mailbody.="<p class=io><b>Email:</b> {$_POST['email']}</p>";
					$mailbody.="<p class=io><b>Телефон:</b> {$_POST['tel']}</p>";
					$mailbody.="<p class=io><b>Город:</b> {$_POST['city']}</p>";
					
					if ($_POST['reason'] == 1) $prichina = "Вопрос по заказу в интернет-магазине";
					elseif ($_POST['reason'] == 2) $prichina = "Вопрос по составу/качеству набора";
					elseif ($_POST['reason'] == 3) $prichina = "Другой вопрос";
					elseif ($_POST['reason'] == 4) $prichina = "Вопрос об оптовой закупке";
					else $prichina = "Не выбрано";
					
					$mailbody.="<p class=io><b>Причина обращения:</b> ".$prichina."</p>";
					
					$mailbody.="<p class=io><b>Сообщение:</b> {$_POST['message']}</p>";
					
					$mailbody.="</body>";
					
					$mailbody = iconv("utf-8", "windows-1251", $mailbody);
					$headers = iconv("utf-8", "windows-1251", $headers);
					
					mail($to, $subj, $mailbody, $headers);
					//mail($to1, $subj, $mailbody, $headers);
					
					if ($_POST['reason'] == 1) mail($to2, $subj, $mailbody, $headers); //Вопрос по заказу в интернет-магазине
					elseif ($_POST['reason'] == 2) mail($to3, $subj, $mailbody, $headers); //Вопрос по составу/качеству набора
					elseif ($_POST['reason'] == 3) mail($to3, $subj, $mailbody, $headers); //Другой вопрос
					elseif ($_POST['reason'] == 4) mail("optsale@firma-gamma.ru", $subj, $mailbody, $headers); //Вопрос об оптовой закупке
					else mail($to3, $subj, $mailbody, $headers); //Не выбрано
					
					$addtxt .= '<div class="contact_group"><span style="color:green;">Спасибо, Ваше сообщение принято!</span></div>';
					$flag = 1;
				}
				
			} else {
				$_POST['name']='';
				$_POST['email']='';
				$_POST['tel']='';
				$_POST['city']='';
				$_POST['reason']='';
				$_POST['message']='';
			}
			if ($flag == 0) {
				$addtxt.='<form class="contact_form" action="" method="post">
								<div class="contact_group">
						            <label for="name">Имя:</label>
						            <input type="text" name="name" class="styler" value="'.$_POST['name'].'" placeholder="Введите ваше имя" required />
						        </div>
						        <div class="contact_group">
						           	<label for="email">Email:</label>
						           	<input type="email" name="email" class="styler" value="'.$_POST['email'].'" placeholder="Введите электронный адрес" required />
						        </div>
						        <div class="contact_group">
						            <label for="tel">Телефон:</label>
						            <input type="tel" name="tel" class="styler" value="'.$_POST['tel'].'" placeholder="Введите номер телефона" required />
						        </div>
						        <div class="contact_group">
						        	<label for="city">Город:</label>
						       		<input type="city" name="city" class="styler" value="'.$_POST['city'].'" placeholder="Введите город" required />
						        </div>
						        <div class="contact_group">
						        	<label for="reason">Причина обращения:</label>
							        <select name="reason" class="selectbox" />
							            <option value="0">Выберите причину обращения</option>
							            <option value="1">Вопрос по заказу в интернет-магазине</option>
							            <option value="2">Вопрос по составу/качеству набора</option>
							            <option value="4">Вопрос об оптовой закупке</option>
							            <option value="3">Другой вопрос</option>
							        </select>
						        </div>
						        <div class="contact_group">
						            <label for="message">Ваше сообщение:</label>
						            <textarea class="styler" name="message" required >'.$_POST['message'].'</textarea>
						        </div>
						        
						        <div class="contact_group"> 
						        	<label>
						        	Введите код '.$_SESSION['check_code'].'</label>
						        	<input type="text" name="code" value="" class="styler code" />
						            <input type="submit" class="button" name="filform" value="Отправить сообщение" />
						       	</div>
						
								<div class="contact_group">
						        	'.$error_text_code.'
						        	'.$error_text_reason.'
						        </div>
				</form>';
			}
	
	
	
	$addtxt .= '</div><!-- #contact_form --></div>';
	
	
	
	echo $addtxt;
	
}
?>

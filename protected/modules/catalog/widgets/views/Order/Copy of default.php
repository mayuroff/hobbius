<?php

//емайл адреса через ,
$orders_email = "shop@igla.ru,khaziyev_m@sb-service.ru";

if(isset($_SESSION['basket_goods'])) $basket_goods=$_SESSION['basket_goods']; else $basket_goods=0;
if(isset($_SESSION['basket_id'])) $basket_id=$_SESSION['basket_id']; else $basket_id=NULL;
if(isset($_SESSION['basket_col'])) $basket_col=$_SESSION['basket_col']; else $basket_col=NULL;

$act = "";
$err_total = 0;
$reg_ordtype = 0;
$reg_ord_type = 0;
$countty_arrive = 0;

	$mas_goods=explode("|",$basket_id);
	$mas_cols=explode("|",$basket_col);
	//Удаление товаров без наличия
	foreach ($mas_goods AS $key=>$val)
	 {
	if ($mas_cols[$key]>0)
		$cart_goods[$val]=$mas_cols[$key];
	}	
	if (!isset($cart_goods)) 
	{
		header("HTTP/1.1 301 Moved Permanently");
		//header("Location: http://miadolla.ru/catalog/");
		exit();
	}	
	//define('ORDER_URI','index.php?a1=2&a2=5');
	$addtxt='<div class="order_div"><h1>Оформление заказа</h1>';

	$addtxt.='<script>
						function pitsot()
						{
							document.getElementById("my").value=document.getElementById("my").value.substr(0, 499);
						}
					</script>';



	if( (isset($_POST['sendcart'])) || (isset($_POST['sendcart2'])) ||($act=="editdata"))
	{
		//Проверка введены ли данные
		if (isset($_POST['country_arrive'])) $country_arrive=$_POST['country_arrive'];
		else $country_arrive=0;
		if (isset($_POST['city_arrive'])) $city_arrive=$_POST['city_arrive']; else $city_arrive=0;
		if (isset($_POST['type_arrive'])) $type_arrive=$_POST['type_arrive']; else $type_arrive=0;
		if ($country_arrive==0) $city_arrive==0;
		if ($country_arrive==1 && $city_arrive==0){ $type_arrive=0;echo '$type_arrive=0';}
		if(isset($_POST["reg_name"])) $reg_name=$_POST["reg_name"]; else $reg_name=NULL;
		if(isset($_POST["reg_surname"])) $reg_surname=$_POST["reg_surname"]; else $reg_surname=NULL;
		if(isset($_POST["reg_name2"])) $reg_name2=$_POST["reg_name2"]; else $reg_name2=NULL;
		if(isset($_POST["reg_email"])) $reg_email=$_POST["reg_email"]; else $reg_email=NULL;
		if(isset($_POST["reg_code"])) $reg_code=$_POST["reg_code"]; else $reg_code=NULL;
		if(isset($_POST["reg_phone"])) $reg_phone=$_POST["reg_phone"]; else $reg_phone=NULL;
		if(isset($_POST["reg_code2"])) $reg_code2=$_POST["reg_code2"]; else $reg_code2=NULL;
		if(isset($_POST["reg_phone2"])) $reg_phone2=$_POST["reg_phone2"]; else $reg_phone2=NULL;
		if(isset($_POST["reg_postcode"])) $reg_postcode=$_POST["reg_postcode"]; else $reg_postcode=NULL;
		if(isset($_POST["reg_city"])) $reg_city=$_POST["reg_city"]; else $reg_city=NULL;
		if(isset($_POST["reg_address"])) $reg_address=$_POST["reg_address"]; else $reg_address=NULL;
		if(isset($_POST["reg_nalichie"])) $reg_nalichie=$_POST["reg_nalichie"]; else $reg_nalichie=2;
		if(isset($_POST["reg_nalichie2"])) $reg_nalichie2=$_POST["reg_nalichie2"]; else $reg_nalichie2=1;
		if(isset($_POST["reg_money"])) $reg_money=$_POST["reg_money"]; else $reg_money=1;
		if(isset($_POST["reg_comments"])) $reg_comments=$_POST["reg_comments"]; else $reg_comments=NULL;
		if(isset($_POST["reg_cel"])) $reg_cel=$_POST["reg_cel"]; else $reg_cel=0;
		if(isset($_POST["reg_ordtype"])) $reg_ordtype=$_POST["reg_ordtype"]; else $reg_ordtype=2;
		if(isset($_POST["city_boxberry"])) $city_boxberry=$_POST["city_boxberry"]; else $city_boxberry=0;
		if(isset($_POST["city_boxberry_ul"])) $city_boxberry_ul=$_POST["city_boxberry_ul"]; else $city_boxberry_ul=NULL;
		if(isset($_POST["city_boxberry_courier"])) $city_boxberry_courier=$_POST["city_boxberry_courier"]; else $city_boxberry_courier=0;
		
		if (($type_arrive!=4)&& strpos($reg_postcode,'Почтомат')) {
			$reg_postcode=NULL;
			$reg_city=NULL;
			$reg_address=NULL;

		}


		//Сохранение данных в сессии
		$_SESSION['city_arrive']=$city_arrive;
		$_SESSION['country_arrive']=$country_arrive;
		$_SESSION['type_arrive']=$type_arrive;
		$_SESSION["reg_name"]=$reg_name;
		$_SESSION["reg_surname"]=$reg_surname;
		$_SESSION["reg_name2"]=$reg_name2;
		$_SESSION["reg_email"]=$reg_email;
		$_SESSION["reg_code"]=$reg_code;
		$_SESSION["reg_phone"]=$reg_phone;
		$_SESSION["reg_code2"]=$reg_code2;
		$_SESSION["reg_phone2"]=$reg_phone2;
		$_SESSION["reg_postcode"]=$reg_postcode;
		$_SESSION["reg_city"]=$reg_city;
		$_SESSION["reg_address"]=$reg_address;
		$_SESSION["reg_nalichie"]=$reg_nalichie;
		$_SESSION["reg_nalichie2"]=$reg_nalichie2;
		$_SESSION["reg_money"]=$reg_money;
		$_SESSION["reg_comments"]=$reg_comments;
		$_SESSION["reg_cel"]=$reg_cel;
		$_SESSION["reg_ordtype"]=$reg_ord_type;
		$_SESSION["city_boxberry"]=$city_boxberry;
		$_SESSION["city_boxberry_ul"]=$city_boxberry_ul;
		$_SESSION["city_boxberry_courier"]=$city_boxberry_courier;
	} else
	{
		//извлечение данных из сессии
		if (isset($_SESSION['city_arrive'])) $city_arrive=$_SESSION['city_arrive']; else $city_arrive=0;
		if (isset($_SESSION['country_arrive'])) $country_arrive=$_SESSION['country_arrive']; else $country_arrive=0;
		if (isset($_SESSION['type_arrive'])) $type_arrive=intval($_SESSION['type_arrive']); else $type_arrive=0;
		if(isset($_SESSION["reg_name"])) $reg_name=$_SESSION["reg_name"]; else $reg_name=NULL;
		if(isset($_SESSION["reg_surname"])) $reg_surname=$_SESSION["reg_surname"]; else $reg_surname=NULL;
		if(isset($_SESSION["reg_name2"])) $reg_name2=$_SESSION["reg_name2"]; else $reg_name2=NULL;
		if(isset($_SESSION["reg_email"])) $reg_email=$_SESSION["reg_email"]; else $reg_email=NULL;
		if(isset($_SESSION["reg_code"])) $reg_code=$_SESSION["reg_code"]; else $reg_code=NULL;
		if(isset($_SESSION["reg_phone"])) $reg_phone=$_SESSION["reg_phone"]; else $reg_phone=NULL;
		if(isset($_SESSION["reg_code2"])) $reg_code2=$_SESSION["reg_code2"]; else $reg_code2=NULL;
		if(isset($_SESSION["reg_phone2"])) $reg_phone2=$_SESSION["reg_phone2"]; else $reg_phone2=NULL;
		if(isset($_SESSION["reg_postcode"])) $reg_postcode=$_SESSION["reg_postcode"]; else $reg_postcode=NULL;
		if(isset($_SESSION["reg_city"])) $reg_city=$_SESSION["reg_city"]; else $reg_city=NULL;
		if(isset($_SESSION["reg_address"])) $reg_address=$_SESSION["reg_address"]; else $reg_address=NULL;
		if(isset($_SESSION["reg_nalichie"])) $reg_nalichie=$_SESSION["reg_nalichie"]; else $reg_nalichie=NULL;
		if(isset($_SESSION["reg_nalichie2"])) $reg_nalichie2=$_SESSION["reg_nalichie2"]; else $reg_nalichie2=NULL;
		if(isset($_SESSION["reg_money"])) $reg_money=$_SESSION["reg_money"]; else $reg_money=1;
		if(isset($_SESSION["reg_comments"])) $reg_comments=$_SESSION["reg_comments"]; else $reg_comments=NULL;
		if(isset($_SESSION["reg_cel"])) $reg_cel=$_SESSION["reg_cel"]; else $reg_cel=NULL;
		if(isset($_SESSION["reg_ordtype"])) $reg_cel=$_SESSION["reg_ordtype"]; else $reg_ord_type=2;
		if(isset($_SESSION["city_boxberry"])) $city_boxberry=$_SESSION["city_boxberry"]; else $city_boxberry=0;
		if(isset($_SESSION["city_boxberry_ul"])) $city_boxberry_ul=$_SESSION["city_boxberry_ul"]; else $city_boxberry_ul=NULL;
		if(isset($_SESSION["city_boxberry_courier"])) $city_boxberry_courier=$_SESSION["city_boxberry_courier"]; else $city_boxberry_courier=0;
	}

	//Проверка корректности данных
	if ( (isset($_POST['sendcart'])) || (isset($_POST['sendcart2'])) )
	{
		$err_total=0;
		if($country_arrive==0){$country_arrive_err='Выберите страну доставки';$err_total++;}
		elseif ($country_arrive==1 && $city_arrive==0) {$city_arrive_err='Выберите место назначения';$err_total++;}
		elseif ($type_arrive==0){$type_arrive_err='Выберите способ доставки';$err_total++;}
		elseif ($countty_arrive==2 && $type_arrive!=2) {$type_arrive_err='Доставка за границу возможна только по почте со 100% предоплатой';$err_total++;}
		elseif ($city_arrive==2 && ($type_arrive==3)){$type_arrive_err='Выбранный способ доставки не доступен вне Московской области';$err_total++;}		
		if ($type_arrive!=0)
		{
			if($reg_name==NULL) {$reg_name_err='Введите имя';$err_total++;}
			if($reg_surname==NULL) {$reg_surname_err='Введите фамилию';$err_total++;}
			
			if ($type_arrive!=5) {
				if ($type_arrive!=4) if($reg_postcode==NULL) {$reg_postcode_err='Введите индекс';$err_total++;}
				if ($type_arrive!=4) {if($reg_city==NULL) {$reg_city_err='Введите город доставки';$err_total++;}}
				if($reg_address==NULL) {$reg_address_err='Введите адрес доставки';$err_total++;}
			}
			
			if ($type_arrive==5) {
				if($city_boxberry==0) {$city_boxberry_err='Выберите пункт Boxberry';$err_total++;}
				else
					if($city_boxberry_ul==0) {$city_boxberry_ul_err='Выберите адрес пункта Boxberry';$err_total++;}
			}
			if ($type_arrive==4) {if($city_boxberry_courier==0) {$city_boxberry_courier_err='Выберите город для курьерской доставки от Boxberry';$err_total++;}}
		
			if ((strlen($reg_email) < 4) && (strlen($reg_phone) < 4))
			{
				if ( ($type_arrive==1) || ($type_arrive==2) || ($type_arrive==5) ) {
					if (strlen($reg_email) < 4) {$email_err='Введите E-mail'; $err_total++;}
				}
				elseif ( ($type_arrive==3) || ($type_arrive==4) ) {
					if (strlen($reg_phone) < 4) {$phone_err='Введите Телефон (1) с кодом'; $err_total++;}
				}
			}
		}
	}
	//if(($act==NULL)||($act=='editdata')) 
	if (!isset($_POST['sendcart'])) $err_total++;
	if (isset($_POST['sendcart2'])) $err_total--;
	//Если есть ошибки (или нет:) Короче вывод формы для заполнения

	if($err_total>0)
	{
		//Запрет отправки без предоплаты по флагу

		$total=0;
		$nonal=0;
		/*
		foreach ($cart_goods AS $key => $val)
		{
			//$r1=mysql_query("select shop_good_id, name from shop_good_sub where id=$key");
			//$s1=mysql_fetch_array($r1);
			$sql = "select shop_good_id, name from shop_good_sub where id=".$key;
			$command=Yii::app()->db->createCommand($sql);
			$r1=$command->query();
			foreach($r1 as $s1)
			{
				$shop_good_id=$s1['shop_good_id'];
				
				//$r1=mysql_query("select value from property where property_item_id=4226972542 and shop_good_id=$shop_good_id");
				//if(mysql_num_rows($r1)>0) 
				//{
				//	$nonal=1;		
				//}
				$sql = "select value from property where property_item_id=4226972542 and shop_good_id=".$shop_good_id;
				$command=Yii::app()->db->createCommand($sql);
				$r1=$command->query();
				if (sizeof($r1) > 0) $nonal=1;
			}
		}	
		*/	
		if ($nonal===1)$addtxt.='<script>var nonalflag=true;</script>';
		else $addtxt.='<script>var nonalflag=false;</script>';
		
		
		
		//Первоначально надо просчитать видимость всех элементов, чтобы не делать это скриптами
		$viss['arr_step1']='';
		$viss['arr_step2']='none';
		$viss['arr_step3']='none';
		$viss['arr_step4']='none';
		$viss['arr_step5']='display:none;';
		$viss['arr_step57']='display:none;';
		$viss['arr_step56']='display:none;';
		$viss['arr_step55']='display:none;';
		$viss['reg_money']='none';
		$viss['arr_atent']='display:none';
		$viss['pochtomat_another']='display:none;';
		if ($nonal===1) $dis['arr3_t1']=' disabled="disabled"';
		else $dis['arr3_t1']='';
		$dis['arr3_t2']='';
		$dis['arr3_t3']='';
		$dis['arr3_t4']='';
		//if ($nonal===1) $dis['arr3_t5']=' disabled="disabled"';
		//else 
		$dis['arr3_t5']='';
		$dis['reg_postcode']='';
		$dis['reg_city']='';
		$dis['reg_address']='';
		if ($country_arrive==1)
		{
			$viss['arr_step2']='';
			//Доставка в Россию
			if ($city_arrive==1)
			{
				$dis['arr3_t4']=' disabled="disabled"';
				if ($type_arrive==5)
				{
					$viss['arr_step5']=''; $viss['arr_step55']=''; $viss['arr_step56']='display:none;'; $viss['arr_step57']='display:none;';
				}
				if ($type_arrive==4)
				{
					$viss['arr_step4']='';
				}
				//Доставка в москву/область
				$viss['arr_step3']='';
				if (($type_arrive==1)||($type_arrive==3)||($type_arrive==2)||($type_arrive==4))
				{
					//доствка почтой/курьером
					$viss['arr_step5']='';
					$viss['arr_step56']='';
					$viss['arr_step57']='';
				}
				/*elseif (($type_arrive==4))
				{
					//Доставка почтоматом
					$viss['pochtomat_another']='';
					if (strstr($reg_postcode,'Почтомат'))
					{
						$viss['arr_step5']='';
						$dis['reg_postcode']=' readonly="readonly"';
						$dis['reg_city']=' readonly="readonly"';
						$dis['reg_address']=' readonly="readonly"';
					}else{
						$viss['arr_step4']='';
					}
				}*/
			}elseif ($city_arrive==2)
			{
				//Доставка по стране
				$viss['arr_step3']='';
				$viss['arr_step4']='none';
				$viss['arr_step5']='';
				$viss['arr_step56']='';
				$viss['arr_step57']='';
				$dis['arr3_t3']=' disabled="disabled"';
				//$dis['arr3_t4']=' disabled="disabled"';
				if (($type_arrive==1)||($type_arrive==2))
				{
					$viss['arr_step5']='';
					$viss['arr_step56']='';
					$viss['arr_step57']='';
				}
				if ($type_arrive==4) {$viss['arr_step4']=''; $viss['arr_step57']='display:none;';}
				if ($type_arrive==5)
				{
					$viss['arr_step5']=''; $viss['arr_step55']=''; $viss['arr_step56']='display:none;'; $viss['arr_step57']='display:none;';
				}
					

			}
		}elseif ($country_arrive==2)
		{
			//Доставка зарубеж
			$viss['arr_step3']='';
			$viss['reg_money']='';
			$viss['arr_atent']='';
			$dis['arr3_t1']=' disabled="disabled"';
			$dis['arr3_t3']=' disabled="disabled"';
			$dis['arr3_t4']=' disabled="disabled"';
			$dis['arr3_t5']=' disabled="disabled"';
			if ($type_arrive==2)
			{
				$viss['arr_step5']='';
				$viss['arr_step56']='';
				$viss['arr_step57']='';
			}
		}
		

		$addtxt.='<p>Для оформления заказа Вам необходимо заполнить следующую форму.</p><p>
</p><form action="/order/" method="post">
<table cellspacing="2" cellpadding="5" border="0"><tbody>';
		
		$addtxt.='<tr class="arr_step1" style="display:'.$viss['arr_step1'].'"><td colspan=2><span style="font-size:16px;font-weight:bold;color:blue;">Выберите страну доставки</span></td></tr>';
		if (isset($country_arrive_err))$addtxt.='<tr><td colspan=2><b style="color:red;">'.$country_arrive_err.'</b></td</tr>';
		$addtxt.='<tr class="arr_step1" style="display:'.$viss['arr_step1'].';"><td>Страна доставки</td><td><select name="country_arrive" value=""><option value="0"';
		
		/*
		$addtxt.='<tr class="arr_step1" style="display:'.$viss['arr_step1'].'"><td colspan=2><b>Страна доставки</b></td></tr>';
		if (isset($country_arrive_err))$addtxt.='<tr><td colspan=2><b style="color:red;">'.$country_arrive_err.'</b></td</tr>';
		$addtxt.='<tr class="arr_step1" style="display:'.$viss['arr_step1'].';"><td></td><td><select name="country_arrive" value=""><option value="0"';
		*/
		
		if ($country_arrive==0)$addtxt.=' selected ';
		$addtxt.=' hidden></option><option value="1"';
		if ($country_arrive==1)$addtxt.=' selected ';
		$addtxt.='>В Россию</option><option value="2"';
		if ($country_arrive==2)$addtxt.=' selected ';
		$addtxt.='>За рубеж</option> </select>
<select class="reg_money" name="reg_money" style="display:'.$viss['reg_money'].';" value=""><option value="1" ';
		if ($reg_money==1)$addtxt.=' selected ';
		$addtxt.='>Рубль</option><option value="2" ';
		if ($reg_money==2)$addtxt.=' selected ';
		$addtxt.='>Доллар</option><option value="3" ';
		if (($reg_money!=1)&&($reg_money!=2))$addtxt.=' selected ';
		$addtxt.='>Евро</option></select></td> </tr>';
		$addtxt.='<tr class="arr_atent" style="'.$viss['arr_atent'].'"><td colspan=2><span style="font-size:16px;font-weight:bold;color:red;">Внимание!</span> <b>Доставка заказа почтой России осуществляется от 1,5 до 3 месяцев.</b></td></tr>';
		
		
		$addtxt.='<tr class="arr_step2" style="display:'.$viss['arr_step2'].'"><td colspan=2><span style="font-size:16px;font-weight:bold;color:blue;">Выберите город доставки</span></td></tr>';
		if (isset($city_arrive_err))$addtxt.='<tr><td colspan=2><b style="color:red;">'.$city_arrive_err.'</b></td</tr>';
		$addtxt.='<tr class="arr_step2" style="display:'.$viss['arr_step2'].';"><td>Город доставки</td><td><select name="city_arrive" value="Выберите значение"><option value="0"';
		
		/*
		$addtxt.='<tr class="arr_step2" style="display:'.$viss['arr_step2'].'"><td colspan=2><b>Город доставки</b></td></tr>';
		if (isset($city_arrive_err))$addtxt.='<tr><td colspan=2><b style="color:red;">'.$city_arrive_err.'</b></td</tr>';
		$addtxt.='<tr class="arr_step2" style="display:'.$viss['arr_step2'].';"><td></td><td><select name="city_arrive" value="Выберите значение"><option value="0"';
		*/
		
		if ($city_arrive==0)$addtxt.=' selected ';
		$addtxt.='hidden></option><option value="1"';
		if ($city_arrive==1)$addtxt.=' selected ';
		$addtxt.='>Москва/Московская область</option><option value="2"';
		if ($city_arrive==2)$addtxt.=' selected ';
		$addtxt.='>Другой</option></select> </td> </tr>';
		
		
		$addtxt.='<tr class="arr_step3" style="display:'.$viss['arr_step3'].'"><td colspan=2><span style="font-size:16px;font-weight:bold;color:blue;">Выберите способ доставки</span></td></tr>';
		if (isset($type_arrive_err))$addtxt.='<tr class="arr_step3" style="display:'.$viss['arr_step3'].'"><td colspan=2><b style="color:red;">'.$type_arrive_err.'</b></td</tr>';
		$addtxt.='<tr class="arr_step3" style="display:'.$viss['arr_step3'].';"><td>Способ отправки</td><td> <div id="arrive_1"><input type="radio" id="arrive_type_1" name="type_arrive" value="1"'.$dis['arr3_t1'];
		
		/*
		$addtxt.='<tr class="arr_step3" style="display:'.$viss['arr_step3'].'"><td colspan=2><b>Выберите способ доставки</b></td></tr>';
		if (isset($type_arrive_err))$addtxt.='<tr class="arr_step3" style="display:'.$viss['arr_step3'].'"><td colspan=2><b style="color:red;">'.$type_arrive_err.'</b></td</tr>';
		$addtxt.='<tr class="arr_step3" style="display:'.$viss['arr_step3'].';"><td></td><td> <div id="arrive_1"><input type="radio" id="arrive_type_1" name="type_arrive" value="1"'.$dis['arr3_t1'];
		*/
		
		if ($type_arrive==1)$addtxt.=' checked="checked" ';
		$addtxt.='/>Ценной посылкой с наложенным платежом (<a href="" style="cursor:pointer" onclick="$(this).parent().find(\'div\').toggle();return false;"><b>подробнее</b></a>)
	<div style="display:none;margin-left:20px;padding-left:10px;border-left:2px solid blue;"> Подробную информацию о стоимости почтовых расходов по Вашему заказу смотрите в разделе
	<a href="/kupit/" target="_blank">Способы доставки</a> . Стоимость наложенного платежа состоит из стоимости 
	товара плюс стоимость почтовых расходов.</div>
</div>
<div id="arrive_2"><input type="radio" id="arrive_type_2" name="type_arrive" value="2"'.$dis['arr3_t2'];
		if ($type_arrive==2)$addtxt.=' checked="checked" ';
		$addtxt.='/>Ценной посылкой со 100% предоплатой (<a href="" style="cursor:pointer" onclick="$(this).parent().find(\'div\').toggle();return false;"><b>подробнее</b></a>)
	<div style="display:none;margin-left:20px;padding-left:10px;border-left:2px solid blue;">При размещении заказов со 100% предоплатой покупателю в течении 3-х рабочих дней отправляется бланк на оплату с 
подробной информацией, о полной или не полной возможности формирования заказа. Как только покупатель оповещает об оплате 
заказ полностью формируется. После поступления денег на расчётный счёт заказ отправляется по почте ценной посылкой. По 
вопросам возникающим при формировании заказов по предоплате менеджеры по почтовым отправкам связываются дополнительно. 
Стоимость почтовых расходов при оформлении заказов по 100% предоплате аналогична стоимости почтовых расходов при отправке 
заказов наложенным платежом.
<br /><br /><span style="color:red">Внимание! При оплате заказа со способом отправки "Ценной 
посылкой со 100 % предоплатой" кредитной картой или электронной валютой,просьба указывать желаемый способ оплаты в поле "
Комментарии к заказу".</span></div></div><div id="arrive_5"><input type="radio" id="arrive_type_5" name="type_arrive" value="5"'.$dis['arr3_t5'];
		if ($type_arrive==5)$addtxt.=' checked="checked" ';
		$addtxt.='/>Пункты выдачи Boxberry по РФ при 100 % предоплате <span style="color:red">new!</span> (<a href="" style="cursor:pointer" onclick="$(this).parent().find(\'div\').toggle();return false;"><b>подробнее</b></a>)
	<div style="display:none;margin-left:20px;padding-left:10px;border-left:2px solid blue;">
Ваш заказ может быть доставлен до пункта выдачи Boxberry в Вашем городе на условиях 100%-ной предоплаты.
<br />Проверьте наличие пункта выдачи заказов в Вашем городе, а также узнайте его адрес, телефоны, режим работы и сроки доставки
 (<a href="/kupit/boxberry/" target="_blank"><strong>здесь</strong></a>).
<br />После поступления заказ в пункт выдачи заказов Вашего города, Вам будет отправленно смс оповещения о готовности к выдаче Вашего заказа. В течении 2-х недель его можно будет забрать.<br />
</div></div>
<div id="arrive_4"><input type="radio" id="arrive_type_4" name="type_arrive" value="4"'.$dis['arr3_t4'];
		if ($type_arrive==4)$addtxt.=' checked="checked" ';
		$addtxt.='/>Доставка курьером Boxberry по РФ при 100 % предоплате <span style="color:red">new!</span> (<a href="" style="cursor:pointer" onclick="$(this).parent().find(\'div\').toggle();return false;"><b>подробнее</b></a>)
		<div style="display:none;margin-left:20px;padding-left:10px;border-left:2px solid blue;">Служба доставки Boxberry , так же осущестляет Курьерскую доставку по городам РФ.
		<br />После поступления заказа в пункт Boxberry Вашего города, с Вами свяжется служба доставки и уточнит дату,и время доставки Вашего заказа.
		<br />Стоимость доставки зависит от веса товарного вложения, а также от региона доставки (<a href="/kupit/boxberrycourier/" target="_blank"><strong>подробнее здесь</strong></a>).</div></div>
<div id="arrive_3"><input type="radio" id="arrive_type_3" name="type_arrive" value="3"'.$dis['arr3_t3']; 
		if ($type_arrive==3)$addtxt.=' checked="checked" ';
		$addtxt.='/>Доставить курьером по Москве / Московской области (<a href="" style="cursor:pointer" onclick="$(this).parent().find(\'div\').toggle();return false;"><b>подробнее</b></a>)
	<div style="display:none;margin-left:20px;padding-left:10px;border-left:2px solid blue;">При заказе товара весом до 3 кг стоимость доставки по Москве 250 рублей. Подробную информацию о стоимости доставки по заказам смотрите в разделе <a href="/kupit/" target="_blank">Способы доставки</a>
	</div>
</div>';













		if (isset($city_boxberry_err))$addtxt.='<tr id="boxberry_err" class="arr_step5" style="'.$viss['arr_step55'].'"><td colspan=2><b style="color:red;">'.$city_boxberry_err.'</b></td</tr>';
		//if ($type_arrive==5) {
		$addtxt.='<tr id="boxberry" class="arr_step5" style="'.$viss['arr_step55'].'"><td>Пункт выдачи <br />заказов Boxberry</td>
		<td>
		<script> 
		function selChange(id,sel)
			{
			$(\'#div_boxberry\').load(\'/ajax/addressboxberry/\', {\'id\':id,\'sel\':sel});
			}
		</script>
		
		
		<select name="city_boxberry" value="Выберите значение" onchange="$(\'#div_boxberry\').html(\'Загрузка...\'); selChange(this.options[this.selectedIndex].text,0);"><option value="0">Выбрать...</option>';
		
		
		$sql = "select * from boxberry ORDER BY city, id";
		$command=Yii::app()->db->createCommand($sql);
		$r=$command->query();
		$nowscity = '';
		$cityboxberrynow = '';
		foreach($r as $s)
		{
			if ($nowscity!=$s['city']){
				$nowscity=$s['city'];
				$addtxt.='<option value="'.$s['id'].'"';
				
				if ($city_boxberry == $s['id']) {$addtxt.=' selected'; $cityboxberrynow = $s['city'];}
				
				
				$addtxt.='>'.$s['city'].'</option>';
			}
		}
		
		$addtxt.='</select></td></tr>';
		
		
		if (isset($city_boxberry_ul_err)) $addtxt.='<tr id="boxberry_err" class="arr_step5" style="'.$viss['arr_step55'].'"><td colspan=2><b style="color:red;">'.$city_boxberry_ul_err.'</b></td</tr>';
		
		
		$addtxt.='<tr id="boxberry_ul" class="arr_step5" style="'.$viss['arr_step55'].'"><td><div id="div_boxberry_text">Aдрес пункта Boxberry</div></td>
			<td><div id="div_boxberry">&nbsp;</div></td>
		</tr>
		
		<script>';
		
			if (($city_boxberry_ul > 0)&&($city_boxberry_ul != NULL)) $addtxt.='selChange("'.$cityboxberrynow.'",\''.$city_boxberry_ul.'\');';
			else $addtxt.='selChange("'.$cityboxberrynow.'",0);';
			
		$addtxt.='</script>';
		//}
		//if ($city_arrive==0)$addtxt.=' selected ';
		//$addtxt.='></option><option value="1"';
		//if ($city_arrive==1)$addtxt.=' selected ';
		//$addtxt.='>Москва/Московская область</option><option value="2"';
		//if ($city_arrive==2)$addtxt.=' selected ';
		//$addtxt.='>Другой</option></select>
		

		if (isset($reg_surname_err))$addtxt.='<tr class="arr_step5" style="'.$viss['arr_step5'].'"><td colspan=2><b style="color:red;">'.$reg_surname_err.'</b></td</tr>';
		$addtxt.='<tr class="arr_step5" style="'.$viss['arr_step5'].'"><td>Фамилия</td><td><input name="reg_surname" class="input_reg" value="'.$reg_surname.'"></td></tr>';
		if (isset($reg_name_err))$addtxt.='<tr class="arr_step5" style="'.$viss['arr_step5'].'"><td colspan=2><b style="color:red;">'.$reg_name_err.'</b></td</tr>';
		$addtxt.='<tr class="arr_step5" style="'.$viss['arr_step5'].'"><td>Имя</td><td><input name="reg_name" class="input_reg" value="'.$reg_name.'"></td></tr>';
		$addtxt.='<tr class="arr_step5" style="'.$viss['arr_step5'].'"><td>Отчество</td><td><input name="reg_name2" class="input_reg" value="'.$reg_name2.'"></td></tr>';
	if (isset($phone_err))$addtxt.='<tr class="arr_step5" style="'.$viss['arr_step5'].'"><td colspan=2><b style="color:red;">'.$phone_err.'</b></td</tr>';	
		$addtxt.='<tr class="arr_step5" style="'.$viss['arr_step5'].'"><td>Телефон (1) с кодом</td><td><input name="reg_code" class="input_reg" style="width:45px;" size="4" value="'.$reg_code.'">-<input name="reg_phone" class="input_reg" value="'.$reg_phone.'"></td></tr>';
		$addtxt.='<tr class="arr_step5" style="'.$viss['arr_step5'].'"><td>Телефон (2) с кодом</td><td><input name="reg_code2" class="input_reg" style="width:45px;" size="4" value="'.$reg_code2.'">-<input name="reg_phone2" class="input_reg" value="'.$reg_phone2.'"></td></tr>';
	if (isset($email_err))$addtxt.='<tr class="arr_step5" style="'.$viss['arr_step5'].'"><td colspan=2><b style="color:red;">'.$email_err.'</b></td</tr>';
		$addtxt.='<tr class="arr_step5" style="'.$viss['arr_step5'].'"><td>E-mail</td><td><input name="reg_email" class="input_reg" value="'.$reg_email.'"></td></tr>';
		if (isset($reg_postcode_err))$addtxt.='<tr class="arr_step5 arr_step56" style="'.$viss['arr_step56'].'"><td colspan=2><b style="color:red;">'.$reg_postcode_err.'</b></td</tr>';
		$addtxt.='<tr class="arr_step5 arr_step56" style="'.$viss['arr_step56'].'"><td>Почтовый индекс</td><td><input name="reg_postcode" class="input_reg" value="'.$reg_postcode.'"><input type="button" id="pochtomat_another" value="Другой почтомат..." style="'.$viss['pochtomat_another'].'"></td></tr>';
		if (isset($reg_city_err))$addtxt.='<tr class="arr_step5 arr_step56 arr_step57" style="'.$viss['arr_step57'].'"><td colspan=2><b style="color:red;">'.$reg_city_err.'</b></td</tr>';
		$addtxt.='<tr class="arr_step5 arr_step56 arr_step57" style="'.$viss['arr_step57'].'"><td>Страна, город</td><td><input name="reg_city" class="input_reg" value="'.$reg_city.'" /></td></tr>';
		
		
		if (isset($city_boxberry_courier_err))$addtxt.='<tr id="boxberry_courier_err" class="arr_step4" style="display:'.$viss['arr_step4'].'"><td colspan=2><b style="color:red;">'.$city_boxberry_courier_err.'</b></td</tr>';
		//if ($type_arrive==4) {
		$addtxt.='<tr id="boxberry_courier" class="arr_step4" style="display:'.$viss['arr_step4'].'"><td>Город для курьерской <br />доставки от Boxberry</td>
		<td>
		<select name="city_boxberry_courier" value="Выберите значение"><option value="0">Выбрать...</option>';

		$sql = "select * from boxberry_courier ORDER BY city, id";
		$command=Yii::app()->db->createCommand($sql);
		$r=$command->query();
		$nowscity = '';
		$cityboxberrynow = '';
		foreach($r as $s)
		{
			if ($nowscity!=$s['city']){
				$nowscity=$s['city'];
				$addtxt.='<option value="'.$s['id'].'"';
				
				if ($city_boxberry_courier == $s['id']) {$addtxt.=' selected'; $cityboxberrynow = $s['city'];}
				
				
				$addtxt.='>'.$s['city'].'</option>';
			}
		}
		
		$addtxt.='</select></td></tr>';
		//}
		
		
		
		if (isset($reg_address_err))$addtxt.='<tr class="arr_step5 arr_step56" style="'.$viss['arr_step56'].'"><td colspan=2><b style="color:red;">'.$reg_address_err.'</b></td</tr>';
		$addtxt.='<tr class="arr_step5 arr_step56" style="'.$viss['arr_step56'].'"><td>Адрес доставки</td><td><input name="reg_address" class="input_reg" value="'.$reg_address.'"></td></tr>';
		$addtxt.='<tr class="arr_step5" style="'.$viss['arr_step5'].'"><td>Комментарии к заказу</td><td>
<div style="margin-bottom:10px;font-size:11px; width:300px;">Внимание! При оплате заказа со способом отправки "Ценной 
посылкой со 100 % предоплатой" кредитной картой или электронной валютой,просьба указывать желаемый способ оплаты в поле 
"Комментарии к заказу".</div><textarea name="reg_comments" id="my" onkeydown="javascript:pitsot()" cols="50" rows="5" class="input_reg">'.$reg_comments.'</textarea><br />(не более 500 символов)</td></tr>';
		$addtxt.='<tr class="arr_step5" style="'.$viss['arr_step5'].'"><td>Наличие</td><td><input type="radio" name="reg_nalichie" value="1"';
		if($reg_nalichie==1)$addtxt.=' checked="checked"';
		$addtxt.='>Отправить только полностью набранный заказ<br /><input type="radio" name="reg_nalichie" value="2" ';
		if($reg_nalichie==2)$addtxt.=' checked="checked"';
		$addtxt.='>Отправить имеющуюся в наличии часть заказа, но не менее половины<br /><input type="checkbox" name="reg_nalichie2" value="1"';
		if($reg_nalichie2==1)$addtxt.=' checked="checked"';
		$addtxt.='>Сообщить об отсутствующих позициях</td></tr>';
		$addtxt.='<tr class="arr_step5" style="'.$viss['arr_step5'].'"><td>Применение</td><td><select name="reg_ordtype"><option value="1"';
		if ($reg_ordtype==1) $addtxt.=' selected="selected"';
		$addtxt.='>в коммерческих целях</option><option value="2"';
		if ($reg_ordtype!=1) $addtxt.=' selected="selected"';
		$addtxt.='>в личных целях</option></select></td></tr>';
		$addtxt.='<!--<script> var bebe=0;$(\'.arr_step1 select\').val(\'0\');; </script>-->';



		$nonal=0;
		/*
		foreach ($cart_goods AS $key => $val)
		{
			//$r=mysql_query("select shop_good_id from shop_good_sub where id=$key");
			//$s=mysql_fetch_array($r);
			$sql = "select shop_good_id from shop_good_sub where id=".$key;
			$command=Yii::app()->db->createCommand($sql);
			$r=$command->query();
			foreach($r as $s)
			{
				//$r1=mysql_query("select value from property where property_item_id=4226972542 and shop_good_id=$s['shop_good_id']");
				//if(mysql_num_rows($r1)>0) $nonal=1;
				$sql = "select value from property where property_item_id=4226972542 and shop_good_id=".$s['shop_good_id'];
				$command=Yii::app()->db->createCommand($sql);
				$r1=$command->query();
				if (sizeof($r1) > 0) $nonal=1;
			}
		}
		*/
$addtxt.='
<tr class="arr_step5" style="'.$viss['arr_step5'].'"><td>&nbsp;</td><td><input type="submit" class="input_reg" name="sendcart" value="Продолжить" style="background-color:#FFFFFF"></td></tr>
</table>
</form>
<script src="/src/js/order.js"></script>
</p>					
				';
	} else
	{	//Если не было ошибок. Вывод подтверждения заказа
		
	$city_courier = "";
			$code = "";
			$address_boxberry = "";
			if($type_arrive==4)
				{
				$sql = "select city from boxberry_courier where id=".$city_boxberry_courier;
				$command=Yii::app()->db->createCommand($sql);
				$r=$command->query();
				foreach($r as $s);
				$city_courier=$s['city'];
				}
			elseif($type_arrive==5)
				{
				$sql = "select city,code,address from boxberry where id=".$city_boxberry_ul;
				$command=Yii::app()->db->createCommand($sql);
				$r=$command->query();
				foreach($r as $s);
				$city_courier=$s['city'];
				$code=' ,КОД пункта:'.$s['code'];
				$address_boxberry = $s['address'];
				}
		
		if ( (isset($_POST['sendcart']))  )
		{
			$total=0;
			$nonal=0;
			/*
			foreach ($cart_goods AS $key => $val)
			{
				//$r1=mysql_query("select shop_good_id, name from shop_good_sub where id=$key");
				//$s1=mysql_fetch_array($r1);
				$sql = "select shop_good_id, name from shop_good_sub where id=".$key;
				$command=Yii::app()->db->createCommand($sql);
				$r1=$command->query();
				foreach($r1 as $s1)
				{
					//$r0=mysql_query("select name, price, koef from shop_good where id=$s1['shop_good_id']");
					//$s0=mysql_fetch_array($r0);
					$sql = "select name, price, koef from shop_good where id=".$s1['shop_good_id'];
					$command=Yii::app()->db->createCommand($sql);
					$r0=$command->query();
					foreach($r0 as $s0) 
					{
						$pr=$s0['price'];
						$tot=$val*$pr;
						$total+=$tot;
					}
					$shop_good_id=$s1['shop_good_id'];
					//$r1=mysql_query("select value from property where property_item_id=4226972542 and shop_good_id=$shop_good_id");
					//if(mysql_num_rows($r1)>0) $nonal=1;
					$sql = "select value from property where property_item_id=4226972542 and shop_good_id=".$shop_good_id;
					$command=Yii::app()->db->createCommand($sql);
					$r1=$command->query();
					if (sizeof($r1) > 0) $nonal=1;
				}
			}
			*/
			foreach ($cart_goods AS $key => $val)
			{
				//$r1=mysql_query("select shop_good_id, name from shop_good_sub where id=$key");
				//$s1=mysql_fetch_array($r1);
				
				$sql = "select * from Goods where GoodID=".$key;
				$command=Yii::app()->db->createCommand($sql);
				$r0=$command->query();
				foreach($r0 as $s0) 
				{
					$pr=$s0['Price'];
					$tot=$val*$pr;
					$total+=$tot;
				}
					/*$shop_good_id=$s1['shop_good_id'];*/
					//$r1=mysql_query("select value from property where property_item_id=4226972542 and shop_good_id=$shop_good_id");
					//if(mysql_num_rows($r1)>0) $nonal=1;
					
					/*$sql = "select value from property where property_item_id=4226972542 and shop_good_id=".$shop_good_id;
					$command=Yii::app()->db->createCommand($sql);
					$r1=$command->query();
					if (sizeof($r1) > 0) $nonal=1;*/
				
			}
			
			if($reg_cel==2)
			{
				$addtxt.='<p style="color:#FF0000">Вы указали, что товар будет использован для перепродажи или в других коммерческих целях. Обращаем Ваше внимание, что оптовыми поставками занимается фирма «Гамма». Настоятельно рекомендуем посетить <a href="http://www.firma-gamma.ru/" style="color:red;font-weight:bold">сайт компании</a> и ознакомиться с условиями работы и оптовыми ценами. Если Вы продолжите оформление заказа на сайте «Miadolla», то Ваш заказ будет посчитан по розничным ценам «Miadolla».</p>';
			}elseif($total>5000)
			{
				$addtxt.='<p style="color:#FF0000">Сумма Вашего заказа превысила 5000 рублей. Обращаем Ваше внимание, что оптовыми поставками занимается фирма «Гамма». Настоятельно рекомендуем посетить <a href="http://www.firma-gamma.ru/" style="color:red;font-weight:bold">сайт компании</a> и ознакомиться с условиями работы и оптовыми ценами. Если Вы продолжите оформление заказа на сайте «Miadolla», то Ваш заказ будет посчитан по розничным ценам «Miadolla».</p>';
			}
			$addtxt.="<p>Проверьте правильность введенных данных.</p>";
			$hiddentypes='<input type="hidden" name="country_arrive" value="'.$country_arrive.'">
				<input type="hidden" name="city_arrive" value="'.$city_arrive.'">
				<input type="hidden" name="type_arrive" value="'.$type_arrive.'">
				<input type="hidden" name="reg_name" value="'.$reg_name.'">
				<input type="hidden" name="reg_name2" value="'.$reg_name2.'">				
				<input type="hidden" name="reg_surname" value="'.stripslashes(htmlspecialchars($reg_surname)).'">				
				<input type="hidden" name="reg_code" value="'.stripslashes(htmlspecialchars($reg_code)).'">
				<input type="hidden" name="reg_phone" value="'.stripslashes(htmlspecialchars($reg_phone)).'">
				<input type="hidden" name="reg_code2" value="'.stripslashes(htmlspecialchars($reg_code2)).'">
				<input type="hidden" name="reg_phone2" value="'.stripslashes(htmlspecialchars($reg_phone2)).'">
				<input type="hidden" name="reg_email" value="'.stripslashes(htmlspecialchars($reg_email)).'">					
				<input type="hidden" name="reg_postcode" value="'.stripslashes(htmlspecialchars($reg_postcode)).'">
				<input type="hidden" name="reg_city" value="'.stripslashes(htmlspecialchars($reg_city)).'">
				<input type="hidden" name="reg_address" value="'.stripslashes(htmlspecialchars($reg_address)).'">
				<input type="hidden" name="reg_comments" value="'.stripslashes(htmlspecialchars($reg_comments)).'">
				<input type="hidden" name="reg_nalichie" value="'.$reg_nalichie.'">				
				<input type="hidden" name="reg_nalichie2" value="'.$reg_nalichie2.'">
				<input type="hidden" name="reg_ordtype" value="'.$reg_ordtype.'">
				<input type="hidden" name="city_boxberry" value="'.$city_boxberry.'">
				<input type="hidden" name="city_boxberry_ul" value="'.$city_boxberry_ul.'">
				<input type="hidden" name="city_boxberry_courier" value="'.$city_boxberry_courier.'">';
			
			if($type_arrive==5)
				{
				$reg_postcode = "";
				$reg_city = $city_courier;
				$reg_address = $address_boxberry;
				}
			if($type_arrive==4)
				{
				$reg_city = $city_courier;
				}
			
			$addtxt.='<form action="/order/" method="post">	
			'.$hiddentypes.'<table cellspacing="2" cellpadding="5" border="0">
				<tr><td><b>Фамилия</b></td><td>'.stripslashes(htmlspecialchars($reg_surname)).'</td></tr>
				<tr><td><b>Имя</b></td><td>'.stripslashes(htmlspecialchars($reg_name)).'</td></tr>
				<tr><td><b>Отчество</b></td><td>'.stripslashes(htmlspecialchars($reg_name2)).'</td></tr>
				<tr><td><b>Телефон 1</b></td><td>('.stripslashes(htmlspecialchars($reg_code)).')-'.stripslashes(htmlspecialchars($reg_phone)).'</td></tr>
				<tr><td><b>Телефон 2</b></td><td>('.stripslashes(htmlspecialchars($reg_code2)).')-'.stripslashes(htmlspecialchars($reg_phone2)).'</td></tr>				
				<tr><td><b>E-mail</b></td><td>'.stripslashes(htmlspecialchars($reg_email)).'</td></tr>	
				<tr><td><b>Почтовый индекс</b></td><td>'.stripslashes(htmlspecialchars($reg_postcode)).'</td></tr>	
				<tr><td><b>Страна, город</b></td><td>'.stripslashes(htmlspecialchars($reg_city)).'</td></tr>
				<tr><td><b>Адрес доставки</b></td><td>'.stripslashes(htmlspecialchars($reg_address)).'</td></tr>
				<tr><td><b>Дополнительная информация</b></td><td>'.stripslashes(htmlspecialchars($reg_comments)).'</td></tr>
				';
			if($reg_nalichie==1) $a1="Отправить только полностью набранный заказ"; else $a1="Отправить имеющуюся в наличии часть заказа, но не менее половины";
			if($reg_nalichie2==1) $a2="<br />Сообщить об отсутствующих позициях"; else $a2=NULL;
			if($type_arrive==1) $a3="Ценной посылкой с наложенным платежом"; elseif($type_arrive==3) $a3="Курьером по Москве / Московской области"; elseif($type_arrive==2) $a3="Ценной посылкой со 100% предоплатой";elseif($type_arrive==4) $a3="Доставка курьером Boxberry по РФ при 100 % предоплате";elseif($type_arrive==5) $a3="Пункты выдачи Boxberry по РФ при 100 % предоплате";
			if($country_arrive==1) $g='Заказ в Россию'; else $g='За пределы РФ';
			if($reg_money==1) $m='Рубль'; elseif($reg_money==2) $m='Доллар'; else $m='Евро';
			if($reg_ordtype==1) $ce='В коммерческих целях'; else $ce='В личных целях';
			
			
			
			$addtxt.='<tr><td><b>Наличие</b></td><td>'.$a1.$a2.'</td></tr><tr><td><b>Способ отправки</b></td><td>'.$a3.'</td></tr><tr><td><b>Государство</b></td><td>'.$g.'</td></tr>';
			if($country_arrive>1) $addtxt.='<tr><td><b>Валюта оплаты</b></td><td>'.$m.'</td></tr>';
			$addtxt.='</table><br /><br /><table width="100%" cellspacing="2" cellpadding="5" border="0">';
			$addtxt.='<tr class="table_cell"><td align="center">Наименование</td><td align="center">Кол-во</td><td align="center">Цена</td><td align="center">Стоимость</td></tr>';

			$total=0;
			$totalves=0;
			$totalob=0;
			/*
			foreach ($cart_goods AS $key => $val)
			{
				//$r1=mysql_query("select shop_good_id, name from shop_good_sub where id=$key");
				//$s1=mysql_fetch_array($r1);
				$sql = "select shop_good_id, name from shop_good_sub where id=".$key;
				$command=Yii::app()->db->createCommand($sql);
				$r1=$command->query();
				foreach($r1 as $s1)
				{
					//$r0=mysql_query("select name, price, koef from shop_good where id=$s1[0]");
					//$s0=mysql_fetch_array($r0);
					$sql = "select name, price, koef from shop_good where id=".$s1['shop_good_id'];
					$command=Yii::app()->db->createCommand($sql);
					$r0=$command->query();
					foreach($r0 as $s0)
					{
						$shop_good_id=$s1['shop_good_id'];
						$nam=iconv("windows-1251", "utf-8", urldecode($s0['name']))." ".iconv("windows-1251", "utf-8", urldecode($s1['name']));
						//$nam=urldecode($nam);
						$pr=$s0['price'];
						$tot=$val*$pr;
						$total+=$tot;
						$koef=1;
						//$r1=mysql_query("select value  from property where property_item_id='1755868031' and shop_good_id=$shop_good_id");						
						//$s1=mysql_fetch_array($r1);
						$sql = "select value  from property where property_item_id='1755868031' and shop_good_id=".$shop_good_id;
						$command=Yii::app()->db->createCommand($sql);
						$r1=$command->query();
						foreach($r1 as $s1)
							$totalves+=($s1['value']*$val)/$s0['koef'];
						//$r1=mysql_query("select value from property where property_item_id='1755871671' and shop_good_id=$shop_good_id");
						//$s1=mysql_fetch_array($r1);
						$sql = "select value from property where property_item_id='1755871671' and shop_good_id=".$shop_good_id;
						$command=Yii::app()->db->createCommand($sql);
						$r1=$command->query();
						foreach($r1 as $s1)				
							$totalob+=$s1['value']*$val*$koef;
						$addtxt.="<tr><td>$nam</td><td align=\"center\">$val</td><td align=\"center\">$pr</td><td align=\"center\">$tot</td></tr>";
					}
				}
			}
			*/
		foreach ($cart_goods AS $key => $val)
			{
				//$r1=mysql_query("select shop_good_id, name from shop_good_sub where id=$key");
				//$s1=mysql_fetch_array($r1);
				
					//$r0=mysql_query("select name, price, koef from shop_good where id=$s1[0]");
					//$s0=mysql_fetch_array($r0);
					$sql = "select * from Goods where GoodID=".$key;
					$command=Yii::app()->db->createCommand($sql);
					$r0=$command->query();
					foreach($r0 as $s0)
					{
						$shop_good_id=$key;
						$nam=$s0['GoodName'];
						//$nam=urldecode($nam);
						$pr=$s0['Price'];
						$tot=$val*$pr;
						$total+=$tot;
						$koef=1;
						//$r1=mysql_query("select value  from property where property_item_id='1755868031' and shop_good_id=$shop_good_id");						
						//$s1=mysql_fetch_array($r1);
						$sql = "select value  from Property where PropertyID='1755868031' and GoodID=".$shop_good_id;
						$command=Yii::app()->db->createCommand($sql);
						$r1=$command->query();
						foreach($r1 as $s1)
							$totalves+=$s1['value']*$val;
						//$r1=mysql_query("select value from property where property_item_id='1755871671' and shop_good_id=$shop_good_id");
						//$s1=mysql_fetch_array($r1);
						$sql = "select value from Property where PropertyID='1755871671' and GoodID=".$shop_good_id;
						$command=Yii::app()->db->createCommand($sql);
						$r1=$command->query();
						foreach($r1 as $s1)				
							$totalob+=$s1['value']*$val*$koef;
						$addtxt.="<tr><td>$nam</td><td align=\"center\">$val</td><td align=\"center\">$pr</td><td align=\"center\">$tot</td></tr>";
					}
				
			}
			#######################################
			$dost='';
			$dost_cena='';
			if(($type_arrive==1)||($type_arrive==2))
			{
				$newves=round($totalves*1000)+200;
				$postcode=$reg_postcode;
				function openpage($link)
				{
					$fd = fopen($link, "r");
					$text="";
					if (!$fd) { echo "Запрашиваемая страница не найдена";  }
					else
					{
						while (!feof ($fd))
						{
							$text .= fgets($fd, 4096);
						}
					}
					fclose ($fd);
					return $text;
				}
				$a=openpage("http://www.russianpost.ru/autotarif/Autotarif.aspx?viewPost=36&countryCode=643&typePost=1&viewPostName=%D0%A6%D0%B5%D0%BD%D0%BD%D0%B0%D1%8F%20%D0%BF%D0%BE%D1%81%D1%8B%D0%BB%D0%BA%D0%B0&countryCodeName=%D0%A0%D0%BE%D1%81%D1%81%D0%B8%D0%B9%D1%81%D0%BA%D0%B0%D1%8F%20%D0%A4%D0%B5%D0%B4%D0%B5%D1%80%D0%B0%D1%86%D0%B8%D1%8F&typePostName=%D0%9D%D0%90%D0%97%D0%95%D0%9C%D0%9D.&weight=".$newves."&value1=".$total."&postOfficeId=".$postcode);
				
				$ar=$a;
				$a=explode('<span id="TarifValue">',$a);
			if (isset($a[1])) 
			{
				//echo "no"; exit;}
				//if (strlen($a[1]) == 0) {echo "no"; exit;}
				$a=explode('</span>',$a[1]);
				$post_price=$a[0];
				$summs=$tot*0.04;
				$summs=round($summs,2);
				if(($post_price=="-")||($post_price=="")) $dost_cena.="<b>не определена.</b>"; else
				{
					$post_price=str_replace(",",".",$post_price);
					$pprice= $summs+$post_price + 94.4;
					$pprice = round($pprice,2);

					$dost_cena.="$pprice";
				}
				$dost.="<p>Расчет стоимости почтовых расходов осуществляется с помощью приблизительной оценки веса заказа, а также <a href=\"http://www.russianpost.ru/rp/servise/ru/home/postuslug/autotarif\" target=\"_blank\">автотарификатора Почты России</a>. Обращаем внимание, что реальная стоимость почтовых услуг <b>может отличаться</b> от ориентировочной.</p>";
			}
			else {echo "Расчет стоимости почтовых расходов осуществляется с помощью приблизительной оценки веса заказа: <a href=\"http://www.russianpost.ru/rp/servise/ru/home/postuslug/autotarif\" target=\"_blank\">автотарификатора Почты России</a>";}
			}
			$total=$total;
			$dost_cena=$dost_cena;
			#########################################
			$addtxt.='<tr><td align="right">&nbsp;</td><td colspan="3" class="table_cell" align="center"><b>Стоимость заказа: '.$total.'</b></td></tr>';
			//$addtxt.='<tr><td align="right">&nbsp;</td><td colspan="3" class="table_cell" align="center"><b>'.$post_price.'<div style="display:none;">'.$ar.'</div></b></td></tr>';
			
			$addtxt.='<tr><td align="right">&nbsp;</td><td colspan="3" class="table_cell" align="center"><b>Ориентировочный вес: '.$totalves.' кг</b></td></tr>';
			
			if(($type_arrive==1)||($type_arrive==2))$addtxt.='<tr><td align="right"><b>Ориентировочная стоимость почтовой доставки: </b></td><td colspan="3" class="table_cell" align="left"><b> '.$dost_cena.'</b></td></tr>';



			$addtxt.='</table>';
			if(($type_arrive==1)||($type_arrive==2))if($dost_cena>=$total && $dost_cena!='<b>не определена.</b>')
			{
				$addtxt.="<p style=\"color:red;font-size:14px;\">Стоимость заказа меньше или равна стоимости доставки. Рекомендуем добавить товары в корзину, чтобы покупка была более выгодной.</p>";		
			}
			if($type_arrive==1)$addtxt.='<strong><p>За осуществление денежного перевода Почта России дополнительно взимает 7% от стоимости наложенного платежа.</strong></p>';

			if($nonal==1) $addtxt.='<p style="color:red">Внимание, возможно в Вашем заказе присутствует мерный заказ. Обратите внимание, что для мерного товара цена указана за сантиметр. Рекомендуем перед оформлением заказа перепроверить количество.</p>';

			$addtxt.="<p>Я, <b>$reg_surname $reg_name $reg_name2</b>, подтверждаю заказ товаров для рукоделия на сумму <b>$total руб.</b> по адресу <b>$reg_postcode, $reg_city, $reg_address</b>. Оплату заказа и доставки гарантирую. Адрес указан правильно. Цены и количество товара в заказе мною проверено и соответствуют моему заказу.</b></p>";

			$addtxt.=$dost;

			$addtxt.='<p>С тарифами на услуги доставки можно ознакомиться в разделе <a href="/kupit/" target="_blank">доставка</a>.</p>';





			function digits($stroka)
			{
				$ln=strlen($stroka);
				if($ln==0) return(0); else
				{
					$knt=0;
					for($i=0;$i<$ln;$i++)
					if($stroka[$i]=='0') $knt++;
					elseif($stroka[$i]=='1') $knt++;
					elseif($stroka[$i]=='2') $knt++;
					elseif($stroka[$i]=='3') $knt++;
					elseif($stroka[$i]=='4') $knt++;
					elseif($stroka[$i]=='5') $knt++;
					elseif($stroka[$i]=='6') $knt++;
					elseif($stroka[$i]=='7') $knt++;
					elseif($stroka[$i]=='8') $knt++;
					elseif($stroka[$i]=='9') $knt++;
					if($knt>0) return(1); else return(0);
				}
			}


			function urlmail($stroka)
			{
				$ln=strlen($stroka);
				$mailok=0;
				for($i=0;$i<$ln;$i++)
				if($stroka[$i]=='@') $mailok=1;
				return($mailok);
			}
			if(  (($reg_code!='')&&(digits($reg_code)))  &&  (($reg_phone!='')&&(digits($reg_phone)))  ) $phone1=1; else $phone1=0;
			if(  (($reg_code2!='')&&(digits($reg_code2)))  &&  (($reg_phone2!='')&&(digits($reg_phone2)))  ) $phone2=1; else $phone2=0;
			$allphone=$phone1+$phone2;
			if (  ($reg_email!='')  && (urlmail($reg_email)) ) $mailok=1; else $mailok=0;
			if(($allphone==0)&&($mailok==0)){$addtxt.='<p style="color:red"><b>Внимание!</b> Настоятельно рекомендуем Вам оставить контактную информацию (e-mail или телефон) для того, чтобы наши менеджеры могли связаться с Вами. В противном случае по усмотрению менеджеров отправка заказа может быть не выполнена. Если заказ все-таки будет отправлен, то мы не гарантируем Вам успешность доставки.</p>';}
			if(($allphone==0)&&($mailok==1))$addtxt.='<p style="color:red"><b>Внимание!</b> Настоятельно рекомендуем Вам оставить контактные телефоны для того, чтобы наши менеджеры могли связаться с Вами. Если мы не сможем с Вами связаться по электронной почте, то по усмотрению менеджеров отправка заказа может быть не выполнена. Если заказ все-таки будет отправлен, то мы не гарантируем Вам успешность доставки.</p>';
			if(($allphone>0)&&($mailok==0))$addtxt.='<p style="color:red"><b>Внимание!</b> Поле e-mail не заполнено или заполнено неверно. Настоятельно рекомендуем Вам оставить адрес электронной почты для того, чтобы наши менеджеры могли связаться с Вами. Если мы не сможем с Вами связаться по телефону, то по усмотрению менеджеров отправка заказа может быть не выполнена. Если заказ все-таки будет отправлен, то мы не гарантируем Вам успешность доставки.</p>';
			if(($allphone==1)&&($mailok==0))$addtxt.='<p style="color:red"><b>Внимание!</b> Рекомендуем Вам оставить два контактных телефона для того, чтобы наши менеджеры могли иметь более надежную возможность связаться с Вами.</p>';
			$addtxt.="<input type=\"submit\" value=\"Подтвердить заказ\" name=\"sendcart2\" class=\"input_reg\" style=\"background-color:#FFFFFF\">";
			$addtxt.='</form>';
			$addtxt.='<form action="/order/" method="post">'.$hiddentypes;								
			$addtxt.='<input type="submit" value="Изменить данные" class="input_reg" style="background-color:#FFFFFF"></form>';
			$addtxt.='<form action="/catalog/" method="post"><input type="submit" value="Продолжить выбор товара" class="input_reg" style="background-color:#FFFFFF"></form>';


		}
		
//if (isset($_POST['sendcart2'])) echo "yess";
//else echo "noo";		
		
		//Финальная отправка заказа. Генерация xml файла
		if (isset($_POST['sendcart2']))
		{
//echo "qwer";

			if($type_arrive==5)
				{
				$reg_postcode = "";
				$reg_city = $city_courier;
				$reg_address = $address_boxberry;
				}
			if($type_arrive==4)
				{
				$reg_city = $city_courier;
				}
			
			$xml='<?xml version="1.0" encoding="windows-1251"?>
<order><onlinestore_id>8</onlinestore_id>
';
			$data=date("j-n-Y");
			//$r=mysql_query("select count(*) from shop_statistic where data='$data'");
			//$s=mysql_fetch_array($r);
			$sql = "select count(*) from shop_statistic where data='".$data."'";
			$command=Yii::app()->db->createCommand($sql);
			$s=$command->queryScalar();
			
			$numb=$s+1+4000;
			$xml.='<number>'.$numb.'/'.$data.'</number>
<client>
<fio>';
			$xml.=stripslashes($reg_surname.' '.$reg_name.' '.$reg_name2).'</fio>
';

			$xml.='<phone>('.stripslashes($reg_code).')-'.stripslashes($reg_phone);
			if($reg_code2!=NULL)
			{
				$xml.=', ('.stripslashes($reg_code2).')-'.stripslashes($reg_phone2).'</phone>
';
			} else $xml.='</phone>
';
			$xml.='<mail>'.stripslashes($reg_email).'</mail>
';

			$xml.='<postal>'.stripslashes($reg_postcode).'</postal>
';

			$xml.='<town>'.stripslashes($reg_city).'</town>
';
			$xml.='<address>'.stripslashes($reg_address).'</address>
';

			if ($city_arrive!=2)$reg_money=1;

			if($reg_nalichie==1) $aa1="Отправить только полностью набранный заказ"; else $aa1="Отправить имеющуюся в наличии часть заказа, но не менее половины";

			if($reg_nalichie2==1) $aa1.=". Сообщить об отсутствующих позициях";

			if($type_arrive==1)
			{
				$bb3="Ценной посылкой с наложенным платежом";
				$sub3='np';
			} elseif($type_arrive==3)
			{
				$bb3="Курьером по Москве / Московской области";
				$sub3='dk';
			} elseif($type_arrive==2)
			{
				$bb3="Ценной посылкой со 100% предоплатой";
				$sub3='pr';
			} elseif ($type_arrive==4)
			{
				$bb3="Доставка курьером Boxberry по РФ";
				$sub3='kr';
			}elseif ($type_arrive==5)
			{
				$bb3='Пункты выдачи Boxberry по РФ';
				$sub3='bb';
			}

			if($reg_money==1) $m='Рубль'; elseif($reg_money==2) $m='Доллар'; else $m='Евро';
			if($country_arrive==1) $g='Заказ в Россию'; else $g='Заказ за пределы РФ';
			if($reg_ordtype==2) $ce='В личных целях'; else $ce='В коммерческих целях';


			$myc='#ФИО#:'.stripslashes($reg_surname.' '.$reg_name.' '.$reg_name2).'
#телефон 1#:('.stripslashes($reg_code).') '.stripslashes($reg_phone).'
#телефон 2#:('.stripslashes($reg_code2).') '.stripslashes($reg_phone2).'
#e-mail#:'.stripslashes($reg_email).'
#почтовый индекс#:'.stripslashes($reg_postcode).'
#страна, город#:'.stripslashes($reg_city).'
#адрес доставки#:'.stripslashes($reg_address).'
#наличие#:'.$aa1.'
#способ отправки#:'.$bb3.'
#государство#:'.$g.'
#валюта#:'.$m.'
#товар будет использован#:'.$ce.'
#комментарий#:'.stripslashes($reg_comments);
        $myc=str_replace("\r\n",' ',$myc);
				$myc=str_replace("\r",' ',$myc);
				$myc=str_replace("\n",' ',$myc);

			$xml.='<comment>'.$myc.'</comment>
';

			if($reg_nalichie==1) $a1="1"; else $a1="2";

			$xml.='<send_condition>'.$a1.'</send_condition>
';

			if($reg_nalichie2==1) $a2="1"; else $a2=NULL;

			$xml.='<stock_notice>'.$a2.'</stock_notice>
';

			$xml.='<prepay>0</prepay>
';

			if($type_arrive==1) $a3="1"; else $a3="2";

			$xml.='<send_type>'.$a3.'</send_type>
';

			$xml.='<delivery_type>'.$sub3.'</delivery_type>
';
			if ($sub3==2)
			{
				//$pochtomat=str_replace('Почтомат №', '', $reg_postcode);
				$postcode=str_replace(' ,КОД пункта:', '', $code);
				$xml.='<delivery_box>'.$postcode.'</delivery_box>';
			}


			$xml.='</client>
<items>
';
			$ayear=date("Y");
			$amonth=date("m");
			$aday=date("d");
			$aaddress=$reg_postcode.", ".$reg_address;

			//mysql_query('insert into manual_order (id, year, month, day, number, city, address, sum, ref, vis, fio, email, fullmoment) values (NULL, '.$ayear.', '.$amonth.', '.$aday.', '.$numb.', "'.$reg_city.'", "'.$aaddress.'", 0, "", 1, "'.$reg_surname.' '.$reg_name.' '.$reg_name2.'", "'.$reg_email.'", '.time().')');
			$sql = 'insert into manual_order (id, year, month, day, number, city, address, sum, ref, vis, fio, email, fullmoment) values (NULL, '.$ayear.', '.$amonth.', '.$aday.', '.$numb.', "'.$reg_city.'", "'.$aaddress.'", 0, "", 1, "'.$reg_surname.' '.$reg_name.' '.$reg_name2.'", "'.$reg_email.'", '.time().')';
			$command=Yii::app()->db->createCommand($sql);
			$command->execute();
			
			//$zozo=mysql_query("select id from manual_order where month=$amonth and day=$aday and year=$ayear and number=$numb");
			//$soso=mysql_fetch_array($zozo);
			$sql = "select id from manual_order where month=".$amonth." and day=".$aday." and year=".$ayear." and number=".$numb;
			$command=Yii::app()->db->createCommand($sql);
			$zozo=$command->query();
			foreach($zozo as $soso);

			/*
			foreach ($cart_goods AS $key => $val)
			{
				//$r1=mysql_query("select * from shop_good_sub where id=$key");
				//$s1=mysql_fetch_array($r1);
				$sql = "select * from shop_good_sub where id=".$key;
				$command=Yii::app()->db->createCommand($sql);
				$r1=$command->query();
				foreach($r1 as $s1)
				{
					//$r0=mysql_query("select * from shop_good where id=".$s1['shop_good_id']);
					//$s0=mysql_fetch_array($r0);
					$sql = "select * from shop_good where id=".$s1['shop_good_id'];
					$command=Yii::app()->db->createCommand($sql);
					$r0=$command->query();
					foreach($r0 as $s0)
					{
						$xml.='<item>';
						$xml.='<id>'.$key.'</id>';
						$xml.='<quantity>'.$val.'</quantity>';
						$s0['name']=iconv("windows-1251", "utf-8", urldecode($s0['name']));
						$s0['name']=ltrim($s0['name']);
						$s0['name']=rtrim($s0['name']);
						$s1['name']=iconv("windows-1251", "utf-8", urldecode($s1['name']));
						$s1['name']=ltrim($s1['name']);
						$s1['name']=rtrim($s1['name']);
						$xml.='<fullname>'.str2xml($s0['name'].' '.$s1['name']).'</fullname>';
						$xml.='</item>';
					}
				}
			}
			 */
			foreach ($cart_goods AS $key => $val)
			{
					$sql = "select * from Goods where GoodID=".$key;
					$command=Yii::app()->db->createCommand($sql);
					$r0=$command->query();
					foreach($r0 as $s0)
					{
						$xml.='<item>';
						
						
						$sql = "select * from Details where GoodID=".$key;
						$command=Yii::app()->db->createCommand($sql);
						$r5=$command->query();
						foreach($r5 as $s5)
						{
							$xml.='<id>'.$s5['DetailID'].'</id>';
						}
						
						
						$xml.='<quantity>'.$val.'</quantity>';
						$s0['GoodName']=$s0['GoodName'];
						$s0['GoodName']=ltrim($s0['GoodName']);
						$s0['GoodName']=rtrim($s0['GoodName']);
						$xml.='<fullname>'.str2xml($s0['GoodName']).'</fullname>';
						$xml.='</item>';
					}
				
			}

			$xml.='</items>';

			$xml.='</order>';




			// тут письмо начало





			$addtxt='<div class="order_div"><h1>Оформление заказа</h1>
				<p><b>Номер Вашего заказа '.$numb.'/'.$data.'</b>
				<p>Заявка на Ваш заказ будет обработана в ближайшее время.</p>
				<p>На указанный Вами e-mail выслано письмо с информацией о заказе.</p>
				<p><strong>Внимание!</strong> Чтобы не создавать Вам лишнее беспокойство, наши менеджеры свяжутся с Вами лишь в тот момент, когда будет получена информации о наличии вашего товара на складе.</p>
			';
			//<p><a href="/catalog/basket/clear/">Очистить корзину</a></p>

			//Отправка письма покупателю
			$mail=$reg_email;
			$headers = "From: Miadolla.Ru <shop@miadolla.ru> \r\n";
			$headers2 = "From: Miadolla.Ru <shop@miadolla.ru> \r\n";
			$su='Информация о розничном заказе';
			$su2="Розничный заказ ".$numb."/".$data." — ".stripslashes($reg_name)." ".stripslashes($reg_surname);
			$su = iconv("utf-8", "windows-1251", $su);
			$su2 = iconv("utf-8", "windows-1251", $su2);
			$subj ='=?windows-1251?B?'.base64_encode($su).'?=';
			$subj2 ='=?windows-1251?B?'.base64_encode($su2).'?=';
			$headers.= "Content-Type: text/html; charset=Windows-1251\r\n";
			$headers2.= "Content-Type: text/html; charset=Windows-1251\r\n";
			$headers.= "MIME-Version: 1.0\r\n";
			$headers2.= "MIME-Version: 1.0\r\n";

			$mailbody='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html>
<head>
<title>miadolla.ru — информация о розничном заказе</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>
<style>
h1{font-family:Arial, Helvetica, sans-serif;font-size:16px;font-weight:bold;}
h2{font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;}
p{font-family:Arial, Helvetica, sans-serif;font-size:12px;}
c11{font-size:11px;}
td{font-family:Arial, Helvetica, sans-serif;font-size:11px;padding:5px;}
.td1{background-color:#DDDDDD;}
.td2{background-color:#EEEEEE;}
.td3{background-color:#F6F6F6;}
</style><body><h1>Информация о Вашем розничном заказе в «Miadolla».</h1>
<p>Здравствуйте, '.stripslashes($reg_name).' '.stripslashes($reg_surname).'!</p>
<p>Спасибо за заказ! Спасибо, что выбрали нас!</p>
Ваш e-mail был указан при оформление розничного заказа в интернет-магазине <a href="http://miadolla.ru">miadolla.ru</a>.<br />
Номер вашей заявки: <b>'.$numb.'/'.$data.'</b>.</p>
<p><b>Важно!</b><br />Пожалуйста сохраните этот номер, в случае возникновения проблем с розничным заказом он будет необходим для идентификации.</p>
';

			if(($type_arrive==1)||($type_arrive==2))
			{
				$mailbody.='<p>Обращаем ваше внимание, что мы не будем Вас беспокоить без повода, поэтому номер посылки мы 
вышлем лишь тогда, когда эта информация появляется у нас. По этому номеру Вы сможете отслеживать путь прохождения посылки</p>
<p>При наличии всего товара в наличии заказ формируется за 2-3 дня и через 3-4 дня (2 раза в неделю) сдается  в почтовую 
компанию. Еще 3-5 дней уходит у почтовой компании на оформление посылки и сдачу ее почте России. При наличии всего товара мы 
сможем сообщить Вам номер вашей посылки примерно через 12-20 дней после принятия вашего заказа. Если часть товара отсутствует 
в наличии, то она заказывается под Ваш заказ. В этом случае с срок отправки заказа увеличивается еще на 5-30 дней.</p>
';
			} elseif ($type_arrive==3) {$mailbody.='<p>Обращаем Ваше внимание на то, что курьер позвонит Вам, как только весь товар будет собран 
и готов к отправке. Обычно это происходит на 3-5 день после заказа при наличии всего товара и на 6-30 день при необходимости 
заказать и привезти товар с оптового склада для Вас.</p>
';
			} else {
				/*$mailbody.='<p>При наличии всего товара в наличии заказ формируется за 2-3 дня и через 
3-4 дня (2 раза в неделю) сдается в почтомат. Почтомат вышлет Вам 
уведомление по электронной почте и смс-сообщение с указанием даты, до 
которой необходимо забрать заказ из почтомата.  Срок хранения заказа в 
почтомате – 3 суток, после чего посылка вернется отправителю.
<br><br>
Если часть товара отсутствует в наличии, то она заказывается под Ваш 
заказ. В этом случае срок отправки заказа увеличивается на 5-30 дней.</p>
';		*/
			}
			if($reg_nalichie==1)
			{
				$mailbody.='<p>Вы выбрали опцию «отправить только полностью набранный заказ». Это обозначает, что если в Вашем 
заказе не будет в наличии хотя бы одного наименования, то до его получения заказ отправлен не будет. К сожалению, часто это 
приводит к задержке в отправке  товара на 2-4 месяца. Бывает так, что отдельные выбранные Вами позиции отсутствуют у нас, не 
привозятся в страну по 2-4 месяца или не производятся производителями. Рекомендуем Вам, при наличии большого списка 
заказанных товаров, написать нам об обязательных товарах — без которых посылку не отправлять и тех, которые желательны. Спасибо за понимание.</p>
';
			}

			$mailbody.='<br />
<h2>Состав розничного заказа:</h2>
<table>
<tr><td class="td1"><b>Наименование</b></td><td class="td1"><b>Цена</b></td><td class="td1"><b>Количество</b></td><td class="td1"><b>Стоимость</b></td></tr>
';



			$mailbody2='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html>
<head>
<title>miadolla.ru — информация о розничном заказе</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>
<style>
h1{font-family:"Courier New", Courier, monospace;font-size:26px;font-weight:bold;}
h2{font-family:"Courier New", Courier, monospace;font-size:20px;font-weight:bold;}
p{font-family:"Courier New", Courier, monospace;font-size:18px;}
c11{font-size:11px;}
td{font-family:"Courier New", Courier, monospace;font-size:16px;padding:5px;}
.td1{background-color:#DDDDDD;}
.td2{background-color:#EEEEEE;}
.td3{background-color:#F6F6F6;}
</style><body>
<h2>'.$numb.'/'.$data." — ".stripslashes($reg_name).' '.stripslashes($reg_surname).'</h1>
';


			$yeap1='<p><strong>Состав розничного заказа:</strong></p>
<table>
<tr><td class="td1"><b>Наименование</b></td><td class="td1"><b>Цена</b></td><td class="td1"><b>Количество</b></td><td class="td1"><b>Стоимость</b></td></tr>
';




			$lk=2;
			$sumpr=0;
			$totalves=0;
			$totalob=0;

			/*
			foreach ($cart_goods AS $key => $val)
			{
				//$r1=mysql_query("select * from shop_good_sub where id=$key");
				//$s1=mysql_fetch_array($r1);
				$sql = "select * from shop_good_sub where id=".$key;
				$command=Yii::app()->db->createCommand($sql);
				$r1=$command->query();
				foreach($r1 as $s1)
				{
					//$r0=mysql_query("select * from shop_good where id=".$s1['shop_good_id']);
					//$s0=mysql_fetch_array($r0);
					$sql = "select * from shop_good where id=".$s1['shop_good_id'];
					$command=Yii::app()->db->createCommand($sql);
					$r0=$command->query();
					foreach($r0 as $s0)
					{
						$koef=$s0['koef'];
						//$koef=1;
						$s0['name']=iconv("windows-1251", "utf-8", urldecode($s0['name']));
						$s0['name']=ltrim($s0['name']);
						$s0['name']=rtrim($s0['name']);
						$s1['name']=iconv("windows-1251", "utf-8", urldecode($s1['name']));
						$s1['name']=ltrim($s1['name']);
						$s1['name']=rtrim($s1['name']);
		
						$mssum=$s0['price']*$val;
		
						$mailbody.='<tr><td class="td'.$lk.'">'.$s0['name'].' '.$s1['name'].'</td><td class="td'.$lk.'" align="center">'.$s0['price'].' р.</td><td class="td'.$lk.'" align="center">'.$val.'</td><td class="td'.$lk.'" align="center">'.$mssum.'</td></tr>
		';
						$yeap1.='<tr><td class="td'.$lk.'">'.$s0['name'].' '.$s1['name'].'</td><td class="td'.$lk.'" align="center">'.$s0['price'].' р.</td><td class="td'.$lk.'" align="center">'.$val.'</td><td class="td'.$lk.'" align="center">'.$mssum.'</td></tr>
		';
		
						$fio=htmlspecialchars($s0['name'].' '.$s1['name']);
						$sum222=$s0['price']*$val;
						//mysql_query('insert into manual_order_items (id, id_order, id_subgood, title, price, kol, sum) values (NULL, '.$soso['id'].', '.$key.', "'.$fio.'", '.$s0['price'].', '.$val.', '.$sum222.')');
						$sql = 'insert into manual_order_items (id, id_order, id_subgood, title, price, kol, sum) values (NULL, '.$soso['id'].', '.$key.', "'.$fio.'", '.$s0['price'].', '.$val.', '.$sum222.')';
						$command=Yii::app()->db->createCommand($sql);
						$command->execute();
						
						if($lk==2) $lk=3; else $lk=2;
		
						$sumpr+=$val*$s0['price'];
		
						//$r2=mysql_query("select value from property where property_item_id='1755868031' and shop_good_id=".$s1['shop_good_id']);
						//$s2=mysql_fetch_array($r2);
						$sql = "select value from property where property_item_id='1755868031' and shop_good_id=".$s1['shop_good_id'];
						$command=Yii::app()->db->createCommand($sql);
						$r2=$command->query();
						if (sizeof($r2) > 0)
						{
							foreach($r2 as $s2)
								$totalves+=$s2['value']*$val/$koef;
						}
						
						//$r2=mysql_query("select value from property where property_item_id='1755871671' and shop_good_id=".$s1['shop_good_id']);
						//$s2=mysql_fetch_array($r2);
						$sql = "select value from property where property_item_id='1755871671' and shop_good_id=".$s1['shop_good_id'];
						$command=Yii::app()->db->createCommand($sql);
						$r2=$command->query();
						if (sizeof($r2) > 0)
						{
							foreach($r2 as $s2)
								$totalob+=$s2['value']*$val/$koef;
						}
					}
				}
			}
			 */
			foreach ($cart_goods AS $key => $val)
			{
					$sql = "select * from Goods where GoodID=".$key;
					$command=Yii::app()->db->createCommand($sql);
					$r0=$command->query();
					foreach($r0 as $s0)
					{
						
						//$koef=1;
						$s0['GoodName']=$s0['GoodName'];
						$s0['GoodName']=ltrim($s0['GoodName']);
						$s0['GoodName']=rtrim($s0['GoodName']);
		
						$mssum=$s0['Price']*$val;
		
						$mailbody.='<tr><td class="td'.$lk.'">'.$s0['GoodName'].'</td><td class="td'.$lk.'" align="center">'.$s0['Price'].' р.</td><td class="td'.$lk.'" align="center">'.$val.'</td><td class="td'.$lk.'" align="center">'.$mssum.'</td></tr>
		';
						$yeap1.='<tr><td class="td'.$lk.'">'.$s0['GoodName'].'</td><td class="td'.$lk.'" align="center">'.$s0['Price'].' р.</td><td class="td'.$lk.'" align="center">'.$val.'</td><td class="td'.$lk.'" align="center">'.$mssum.'</td></tr>
		';
		
						$fio=htmlspecialchars($s0['GoodName']);
						$sum222=$s0['Price']*$val;
						//mysql_query('insert into manual_order_items (id, id_order, id_subgood, title, price, kol, sum) values (NULL, '.$soso['id'].', '.$key.', "'.$fio.'", '.$s0['price'].', '.$val.', '.$sum222.')');
						$sql = 'insert into manual_order_items (id, id_order, id_subgood, title, price, kol, sum) values (NULL, '.$soso['id'].', '.$key.', "'.$fio.'", '.$s0['Price'].', '.$val.', '.$sum222.')';
						$command=Yii::app()->db->createCommand($sql);
						$command->execute();
						
						if($lk==2) $lk=3; else $lk=2;
		
						$sumpr+=$val*$s0['Price'];
		
						//$r2=mysql_query("select value from property where property_item_id='1755868031' and shop_good_id=".$s1['shop_good_id']);
						//$s2=mysql_fetch_array($r2);
						$sql = "select value from Property where PropertyID='1755868031' and GoodID=".$key;
						$command=Yii::app()->db->createCommand($sql);
						$r2=$command->query();
						if (sizeof($r2) > 0)
						{
							foreach($r2 as $s2)
								$totalves+=$s2['value']*$val;
						}
						
						//$r2=mysql_query("select value from property where property_item_id='1755871671' and shop_good_id=".$s1['shop_good_id']);
						//$s2=mysql_fetch_array($r2);
						$sql = "select value from Property where PropertyID='1755871671' and GoodID=".$key;
						$command=Yii::app()->db->createCommand($sql);
						$r2=$command->query();
						if (sizeof($r2) > 0)
						{
							foreach($r2 as $s2)
								$totalob+=$s2['value']*$val;
						}
					}
				
			}

			//mysql_query('update manual_order set sum='.$sumpr.' where id='.$soso['id']);
			$sql = 'update manual_order set sum='.$sumpr.' where id='.$soso['id'];
			$command=Yii::app()->db->createCommand($sql);
			$command->execute();

			$mailbody.='<tr><td class="td1"><b>Сумма заказа:</b></td><td class="td1" colspan="3" align="center"><b>'.$sumpr.' р.</b></td></tr>';
			$mailbody.='<tr><td class="td3"><b>Примерный вес заказа, не более *</b></td><td class="td3" colspan="3" align="center">'.round($totalves,4).' кг</td></tr>';
			$mailbody.='<tr><td class="td3"><b>Примерный объем заказа, не более</b></td><td class="td3" colspan="3" align="center">'.round($totalob,4).' л</td></tr>';

			$yeap1.='<tr><td class="td1"><b>Сумма заказа:</b></td><td class="td1" colspan="3" align="center"><b>'.$sumpr.' р.</b></td></tr>';
			$yeap1.='<tr><td class="td3"><b>Примерный вес заказа, не более *</b></td><td class="td3" colspan="3" align="center">'.round($totalves,4).' кг</td></tr>';
			$yeap1.='<tr><td class="td3"><b>Примерный объем заказа, не более</b></td><td class="td3" colspan="3" align="center">'.round($totalob,4).' л</td></tr></table><br /><br />* Примерный вес заказа указан без упаковки.';



			$mailbody.='</table><br /><br />* Примерный вес заказа указан без упаковки.<br /><br /><h2>Дополнительные данные:</h2><table>';

			$yeap2='<h2>Дополнительные данные:</strong></h2><table>';


			$phones=NULL;
			if(($reg_code!='')&&($reg_phone!='')) $phones=stripslashes("($reg_code)-$reg_phone");
			if(($reg_code2!='')&&($reg_phone2!=''))
			{
				if($phones!=NULL) $phones.=', ';
				$phones.=stripslashes("($reg_code2)-$reg_phone2");
			}

			if($reg_nalichie==1) $a1="Отправить только полностью набранный заказ."; else $a1="Отправить имеющуюся в наличии часть заказа, но не менее половины.";

			if($reg_nalichie2==1) $a1.="<br />Сообщить об отсутствующих позициях";

			if($type_arrive==1) $a3="Доставка: Ценной посылкой с наложенным платежом."; elseif($type_arrive==2) $a3="Отправить заказ ценной посылкой при 100% предоплате"; elseif($type_arrive==3) $a3="Доставка: Курьером по Москве / Московской области.";
			elseif($type_arrive==4) $a3="Доставка курьером Boxberry по РФ при 100 % предоплате";elseif($type_arrive==5) $a3="Пункты выдачи Boxberry по РФ при 100 % предоплате";

			if($reg_money==1) $m='Рубль'; elseif($reg_money==2) $m='Доллар'; else $m='Евро';
			if($country_arrive==1) $g='Заказ в Россию'; else $g='Заказ за пределы РФ';
			if($reg_ordtype==2) $ce='В личных целях'; else $ce='Для перепродажи или в других коммерческих целях';

			$mailbody.='<tr><td class="td2"><b>ФИО</b></td><td class="td2">'.stripslashes($reg_surname.' '.$reg_name.' '.$reg_name2).'</td></tr>
			<tr><td class="td3"><b>E-mail</b></td><td class="td3">'.stripslashes($mail).'</td></tr>
<tr><td class="td3"><b>Телефоны</b></td><td class="td3">'.stripslashes($phones).'</td></tr>
<tr><td class="td2"><b>Адрес</b></td><td class="td2">'.stripslashes($reg_postcode.', '.$reg_city.', '.$reg_address).'</td></tr>
<tr><td class="td3"><b>Комментарии</b></td><td class="td3">'.stripslashes($reg_comments).'</td></tr>
<tr><td class="td2"><b>Наличие</b></td><td class="td2">'.$a1.'</td></tr>
<tr><td class="td3"><b>Способ отправки</b></td><td class="td3">'.$a3.'</td></tr>
<tr><td class="td3"><b>Государство</b></td><td class="td3">'.$g.'</td></tr>';
			if($country_arrive>1) $mailbody.='<tr><td class="td3"><b>Валюта оплаты</b></td><td class="td3">'.$m.'</td></tr>';
			$mailbody.='<tr><td class="td3"><b>Товар будет использован</b></td><td class="td3">'.$ce.'</td></tr>';
			$mailbody.='</table><br /><br />';

			$quse=NULL;

			if($type_arrive==1)
			{
				$quse[1]=1;
				$quse[5]=1;
				$quse[6]=1;
				$quse[17]=1;
				$quse[9]=1;
				$quse[10]=1;
				$quse[16]=1;
				$quse[18]=1;
				$quse[19]=1;
			}elseif($type_arrive==3)
			{
				$quse[3]=1;
				$quse[5]=1;
				$quse[7]=1;
				$quse[9]=1;
				$quse[16]=1;
			}elseif($type_arrive==2)
			{
				$quse[2]=1;
				$quse[4]=1;
				$quse[5]=1;
				$quse[6]=1;
				$quse[17]=1;
				$quse[8]=1;
				$quse[9]=1;
				$quse[10]=1;
				$quse[16]=1;
			}elseif($type_arrive==4)
			{
				//Вопросы и ответы для доставки в почтомат
			}


			$mailbody.='<h2>Вопросы-ответы</h2>';
		if ($quse!=NULL)
			foreach($quse as $id => $ed)
			{
				//$r=mysql_query('select * from manual_faq where id='.$id);
				//$s=mysql_fetch_array($r);
				$sql = 'select * from manual_faq where id='.$id;
				$command=Yii::app()->db->createCommand($sql);
				$r=$command->query();
				foreach($r as $s);
				
				$mailbody.='<p><strong>'.$s['ask'].'</strong></p>'.$s['answer'];
			}

			$mailbody.='<br /><h2>Обратная связь</h2><p>
В случае возникновения каких-то вопросов, связанных с розничным заказом, напишите нам электронное письмо на адрес <a href="mailto:shop@miadolla.ru">shop@miadolla.ru</a>. В письме укажите номер вашей заявки - <b>'.$numb.'/'.$data.'</b>.</p>
<p>Также с нами можно связаться по телефонам (495) 603-8763, 603-8759.</p></body></html>	';

			$yeap2.='<tr><td class="td2"><b>ФИО</b></td><td class="td2">'.stripslashes($reg_surname.' '.$reg_name.' '.$reg_name2).'</td></tr>
<tr><td class="td3"><b>E-mail</b></td><td class="td3">'.stripslashes($mail).'</td></tr>
<tr><td class="td3"><b>Телефоны</b></td><td class="td3">'.stripslashes($phones).'</td></tr>
<tr><td class="td2"><b>Адрес</b></td><td class="td2">'.stripslashes($reg_postcode.', '.$reg_city.', '.$reg_address).'</td></tr>
<tr><td class="td3"><b>Комментарии</b></td><td class="td3">'.stripslashes($reg_comments).'</td></tr>
<tr><td class="td2"><b>Наличие</b></td><td class="td2">'.$a1.'</td></tr>
<tr><td class="td3"><b>Способ отправки</b></td><td class="td3">'.$a3.'</td></tr>
<tr><td class="td3"><b>Государство</b></td><td class="td3">'.$g.'</td></tr>';
			if($country_arrive>1) $yeap2.='<tr><td class="td3"><b>Валюта оплаты</b></td><td class="td3">'.$m.'</td></tr>';
			$yeap2.='<tr><td class="td3"><b>Товар будет использован</b></td><td class="td3">'.$ce.'</td></tr>';
			$yeap2.='</table>';

			$mailbody2.=$yeap2.'<br /><br />'.$yeap1.'</body></html>';


			$subj2.=' ('.$sub3.')';
if (!defined('___NOMAIL___'))
{
			$mailbody = iconv("utf-8", "windows-1251", $mailbody);
			$mailbody2 = iconv("utf-8", "windows-1251", $mailbody2);
			
			$headers = iconv("utf-8", "windows-1251", $headers);
			$headers2 = iconv("utf-8", "windows-1251", $headers2);
	
			mail($mail, $subj, $mailbody, $headers);
			
			$mas = explode(',', $orders_email, 100);
			if (count($mas) > 0)
			{
				for($i=0;$i<count($mas);$i++)
					mail($mas[$i], $subj2, $mailbody2, $headers2);
			}
			
			//очистка корзины
			$_SESSION['basket_goods']=0;
			$_SESSION['basket_id']=NULL;
			$_SESSION['basket_col']=NULL;

			if(($reg_cel==2)||($sumpr>5000))
			{
				//	mail("goryavskaya@firma-gamma.ru", $subj2, $mailbody2, $headers2);
				//	mail("eugenk@firma-gamma.ru", $subj2, $mailbody2, $headers2);
			}
}


			//if($reg_comments!='zzz')
			//{

$xml = iconv("utf-8", "windows-1251", $xml);

			$fname='/var/www/vhosts/miadolla.ru/ord/'.$numb.'-'.$data.'.xml';
			$fname2='/var/www/vhosts/miadolla.ru/orders_backup/'.$numb.'-'.$data.'.xml';
			$fzf=fopen($fname,"w");
			$fzf2=fopen($fname2,"w");
			fwrite($fzf,$xml);
			fwrite($fzf2,$xml);
			fclose($fzf);
			fclose($fzf2);
			rename("/var/www/vhosts/miadolla.ru/ord/".$numb.'-'.$data.'.xml',"/var/www/vhosts/miadolla.ru/ord/".$numb.'-'.$data.'.xmt');
			rename("/var/www/vhosts/miadolla.ru/orders_backup/".$numb.'-'.$data.'.xml',"/var/www/vhosts/miadolla.ru/orders_backup/".$numb.'-'.$data.'.xmt');
			copy('/var/www/vhosts/miadolla.ru/ord/'.$numb.'-'.$data.'.xmt','/var/www/vhosts/miadolla.ru/ord/'.$numb.'-'.$data.'.xmt');
			copy('/var/www/vhosts/miadolla.ru/orders_backup/'.$numb.'-'.$data.'.xmt','/var/www/vhosts/miadolla.ru/orders_backup/'.$numb.'-'.$data.'.xmt');
			$xml2=htmlentities($xml);
			$tim=time();
			//mysql_query("insert into shop_statistic (id, data, fullmoment, numb_at_day, xml) values (NULL, \"$data\", $tim, $numb, \"$xml2\")");
			$sql = "insert into shop_statistic (id, data, fullmoment, numb_at_day, xml) values (NULL, \"".$data."\", ".$tim.", ".$numb.", \"".$xml2."\")";
			$command=Yii::app()->db->createCommand($sql);
			$command->execute();
			
			//}
			// здесь отправка письма
			
			/*
			<script>$(function(){var yaParams= { order_id:"'.$tim.'", order_price: '.$sumpr.' ,currency:"RUR",exchange_rate:1};
					 try {yaCounter26018310.reachGoal("SEND_ORDER"); yaCounter26018310.params(yaParams);} catch(e){};
					//Google_analitics 
			*/
			
			/*
			<script>$(function(){var yaParams= { order_id:"'.$tim.'", order_price: '.$sumpr.' ,currency:"RUR",exchange_rate:1};
					 try {yaCounter26018310.reachGoal("SEND_ORDER",yaParams);} catch(e){};
					//Google_analitics
			 */
			
			$addtxt.='<script type="text/javascript">
					    $(window).load(function() {
					    	var yaParams = {order_id:"'.$tim.'", order_price: '.$sumpr.' ,currency:"RUR",exchange_rate:1};
					        try {yaCounter26018310.reachGoal(\'SEND_ORDER\',yaParams);} catch(e){};
					    });
					</script>';

			$addtxt.='<script>$(function(){
					 
					//Google_analitics

					
					try {
						ga(\'require\', \'ecommerce\', \'ecommerce.js\');
						ga(\'ecommerce:addTransaction\', { \'id\':\''.$soso['id'].'\',\'affiliation\':\'MIADOLLA\',\'revenue\':\''.$sumpr.'\',\'shipping\':\'0\',\'tax\':\'0\'});
					
						';
			//Отправка товаров
			//$ss=mysql_query('SELECT id_subgood,title,price,kol FROM manual_order_items WHERE id_order='.$soso[0]);
			
			$sql = 'SELECT id_subgood,title,price,kol FROM manual_order_items WHERE id_order='.$soso['id'];
			$command=Yii::app()->db->createCommand($sql);
			$ss=$command->query();
			foreach($ss as $rr)
			{
				$addtxt.='ga(\'ecommerce:addItem\', {\'id\':\''.$soso['id'].'\',\'name\':\''.$rr['title'].'\',\'sku\':\''.$rr['id_subgood'].'\',\'category\':\'\',\'price\':\''.$rr['price'].'\',\'quantity\':\''.$rr['kol'].'\'});
					';
			}
			$addtxt.='ga(\'ecommerce:send\');
					}catch(e){};';
			$addtxt.='});</script>';


		}


		
	}
$addtxt .= "</div>";
echo $addtxt;

function str2xml ($str)
{
	//var $tmp;
	$tmp=str_replace('&','&amp;',$str);
	$tmp=str_replace('\'','&apos;',$tmp);
	$tmp=str_replace('"','&quot;',$tmp);
	$tmp=str_replace('<','&lt;',$tmp);
	$tmp=str_replace('>','&gt',$tmp);
	return $tmp;
}

?>
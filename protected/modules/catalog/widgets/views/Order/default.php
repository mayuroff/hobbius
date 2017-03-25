<?php

Yii::import('application.extensions.PFBC.*');
//require_once('Form.php');
Yii::setPathOfAlias('PFBC',Yii::getPathOfAlias('application.extensions.PFBC'));
//Yii::registerAutoloader(array($this, 'Load'), true);

?>
<div class="order_div">
	<h1 style="text-align: center;">Оформление заказа</h1>
</div>
<script type="text/javascript" src="/src/js/kladr/core.js"></script>
<script type="text/javascript" src="/src/js/kladr/kladr.js"></script>
<script type="text/javascript" src="/src/js/kladr/kladr_zip.js"></script>
<script type="text/javascript" src="/src/js/order_new.js?v=3"></script>
<link rel="stylesheet" type="text/css" href="/src/css/order.css">

<?php

	$addtxt = '';
	if(isset($_SESSION['basket_goods'])) $basket_goods=$_SESSION['basket_goods']; else $basket_goods=0;
	if(isset($_SESSION['basket_id'])) $basket_id=$_SESSION['basket_id']; else $basket_id=NULL;
	if(isset($_SESSION['basket_col'])) $basket_col=$_SESSION['basket_col']; else $basket_col=NULL;
	
	$mas_goods=explode("|",$basket_id);
	$mas_cols=explode("|",$basket_col);
	foreach ($mas_goods AS $key=>$val)
	{
		if ($mas_cols[$key]>0) $cart_goods[$val]=$mas_cols[$key];
	}
	
	if (!isset($cart_goods)) 
	{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: http://miadolla.ru/");
		exit();
	}
	
	$delivery_options[2]='<b>Почта России - <span style="color:#a23520;">350 руб</span></b><br /><span style="font-size: 8pt/10pt;color: grey;">срок доставки: 7-21 дней</span>';
	$delivery_options[3]='<b>Курьером по Москве - <span style="color:#a23520;">250 руб</span></b><br /><span style="font-size: 8pt/10pt;color: grey;">срок доставки: 1-2 дня</span>';
	//$delivery_options[6]='<b>Самовывоз - <span style="color:#a23520;">бесплатно</span></b><br /><span style="font-size: 8pt/10pt;color: grey;">срок выдачи заказа: на следующий рабочий день<br />г.Москва, 11-я Парковая ул., д. 9/35</span>';
	
	$delivery_mail[2]='Почта России';
	$delivery_mail[3]='Курьером по Москве';
	$delivery_mail[4]='Доставка курьером Boxberry по РФ при 100 % предоплате';
	$delivery_mail[5]='Пункты выдачи Boxberry по РФ при 100 % предоплате';
	//$delivery_mail[6]='Самовывоз';
	
	$delivery_type[2]='1';
	$delivery_type[3]='2';
	$delivery_type[4]='2';
	$delivery_type[5]='2';
	$delivery_type[6]='2';
	
	$pay_code[1]='pr';
	$pay_code[2]='np';
	$pay_code[3]='dk';
	$pay_code[4]='kr';
	$pay_code[5]='bb';
	$pay_code[6]='sm';
	
	$pay_code[7]='kr'; //Доставка курьером Top Delivery
	$pay_code[8]='bb'; //Пункты выдачи Top Delivery
	
	//Способы оплаты
	$pay_options[1]='<b>Наложенный платеж</b><br /><span style="font-size: 8pt/10pt;color: grey;">оплата при получении заказа в отделении Почты России</span>';
	$pay_options[2]='<b>Банковской картой</b><br /><span style="font-size: 8pt/10pt;color: grey;">оплата после согласования заказа с менеджером контакт-центра</span>';
	$pay_options[3]='<b>Наличный расчет</b><br /><span style="font-size: 8pt/10pt;color: grey;">оплата при получении заказа</span>';
	$pay_options[4]='<b>Электронными деньгами</b><br /><span style="font-size: 8pt/10pt;color: grey;">оплата после согласования заказа с менеджером контакт-центра</span>';
	
	//Страна доставки
	$delivery_country[1]='В Россию';
	$delivery_country[2]='За рубеж';
	
	//Поиск товаров в корзине без доставки наложенным платежом
	$nonal=0;
	/*foreach ($cart_goods AS $key => $val)
	{
		$sql = "select shop_good_id, name from shop_good_sub where id=".$key;
		$command=Yii::app()->db->createCommand($sql);
		$r1=$command->query();
		foreach($r1 as $s1)
		{
			$shop_good_id=$s1['shop_good_id'];
			$sql = "select value from property where property_item_id=4226972542 and shop_good_id=".$shop_good_id;
			$command=Yii::app()->db->createCommand($sql);
			$r1=$command->query();
			if (sizeof($r1) > 0) $nonal=1;
		}
	}*/
	if ($nonal===1)$addtxt.='<script>var nonalflag=true;</script>';
	else $addtxt.='<script>var nonalflag=false;</script>';
	
	$ORDER_DATA=Array();
	
	$view='form';
	if (isset($_POST['submit'])&&($_POST['submit']=='order'))
	{
		//LOAD_DATA
		include ('order/datafromses.php');
		//FROM_VALIDATION
		$valid = false;
		include ('order/form_validation.php');
		if ($valid) $view='order';
	} else {
		if (isset($_POST['form'])&&($_POST['form']=='order_form'))
		{
			//PARSE POST DATA
			include ('order/parse_post.php');
			//FORM_VALIDATION
			$valid = false;
			include ('order/form_validation.php');
			//SAVE_DATA
			include ('order/datatoses.php');
			//if ($valid) $view='submit';
			if ($valid) $view='order';
		}else {
			//LOAD_DATA
			include ('order/datafromses.php');
		}
	}
	
	if ($view=='form')
	{
		//Создание формы оформления заказа
		include ('order/form.php');
		//Если тип доставки еще не выбран - скрываем поля ввода
		if ($ORDER_DATA['type_arrive']!=0) $client_st='';
		else $client_st='.client_data{display:none;}';
		$addtxt.='<style type="text/css">label{display:block;}label.inline{display:inline;}'.'</style>';
		$form_order->setValues($ORDER_DATA);
		//Весь вывод - лишь форма.
		$addtxt.=$form_order->render(true);	
		
		
		//$addtxt.=$ORDER_DATA['type_arrive'];
		//$addtxt.=$ORDER_DATA['box_type'];
		
		if ($ORDER_DATA['type_arrive']>=1000)
		{
			$addtxt.='<script>$(\'.delivery_select\').parents(\'div.controls\').append(\'';
			//Нужно добавить доступные способы доставки в список способов и выделить нужный
			$sql = 'SELECT idcity FROM leo_delivery WHERE iddeliv='.$ORDER_DATA['type_arrive'];
			$command=Yii::app()->db->createCommand($sql);
			$s1=$command->query();
			$delivery_city = 0;
			foreach($s1 as $r1) {
				$delivery_city = $r1['idcity'];
			}
			$sql = 'SELECT delivtype,delivname,delivtime,delivaddress,defcost,speccode,iddeliv FROM leo_delivery WHERE idcity='.$delivery_city;
			$command=Yii::app()->db->createCommand($sql);
			$s1=$command->query();
			foreach($s1 as $specdelivery) {
				
				if ($specdelivery['delivtype']==5)
				{  //Доставка TopDelivery
					$iddeliv = $specdelivery['iddeliv'];
					$delivtime = $specdelivery['delivtime'];
					$Code = 'c5';
					$price = 0;
					
					$soap = new SoapClient('http://is.topdelivery.ru/api/soap/w/1.2/?WSDL', array('login'=>"tdsoap",'password'=>"fc7a00f11c1bfa9f5b69e0be9117738e"));
					$speccode = explode("-", $specdelivery['speccode']);
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
						
							$addtxt.='<label class="radio specdeliv specdelivcode" style="display: block;"> <input type="radio" name="type_arrive" class="delivery_select" ';
							if ($specdelivery['iddeliv']==$ORDER_DATA['type_arrive'] && $key==$ORDER_DATA['box_type']) $addtxt.=' checked="checked" ';
							$addtxt.='required="" value="'.$iddeliv.'" data-val="'.$key.'"> <b>Пункт выдачи заказов Top Delivery - <span style="color:#a23520;">'.$price.' руб.</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: ';
							$addtxt.=$delivtime; 
							$addtxt.=')';
							//echo $r['speccode'];
							$addtxt.='<br>'.$val;
							$addtxt.='</span> </label>';
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
					
						$addtxt.='<label class="radio specdeliv specdelivcode" style="display: block;"> <input type="radio" name="type_arrive" class="delivery_select" ';
						if ($specdelivery['iddeliv']==$ORDER_DATA['type_arrive'] && $Code==$ORDER_DATA['box_type']) $addtxt.=' checked="checked" ';
						$addtxt.=' required="" value="'.$iddeliv.'" data-val="'.$Code.'"> <b>Доставка курьером Top Delivery - <span style="color:#a23520;">'.$price.' руб.</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: ';
						$addtxt.=$delivtime;
						$addtxt.=')';
						//echo $r['speccode'];
						$addtxt.='</span> </label>';
					}
				
				}
				/*
				if ($specdelivery['delivtype']==2)
				{  //Доставка боксбери ПВЗ
					$url='http://api.boxberry.de/json.php?token=11656.rzpqafcd&method=ListPoints&CityCode='.$specdelivery['speccode'];
					$handle = fopen($url, "rb");
					$contents = stream_get_contents($handle);
					fclose($handle);
					$pvz=json_decode($contents,true);
					if(count($pvz)<=0 or ( (isset($pvz[0]['err'])) && $pvz[0]['err'] )){continue;}
					else
					{
						$url='http://api.boxberry.de/json.php?token=11656.rzpqafcd&method=DeliveryCosts&weight=1000&target='.$pvz[0]['Code'].'&ordersum=0&deliverysum=0&paysum=0';
							
						$handle = fopen($url, "rb");
						$contents = stream_get_contents($handle);
						fclose($handle);
						$price=json_decode($contents,true);
						if(count($price)<=0 or ( (isset($price[0]['err'])) && $price[0]['err'] )){continue;}
						$arr = array();
						foreach ($pvz AS $key=>$val)
						{
							if (!in_array($val['Code'], $arr)) {
								$arr[] = $val['Code'];
								$addtxt.='<label class="radio specdeliv specdelivcode" style="display: block;"> <input type="radio" name="type_arrive" class="delivery_select" ';
								if ($specdelivery['iddeliv']==$ORDER_DATA['type_arrive'] && $val['Code']==$ORDER_DATA['box_type']) $addtxt.=' checked="checked" ';
								$addtxt.='required="" value="'.$specdelivery['iddeliv'].'" data-val="'.$val['Code'].'"> <b>Пункт выдачи Boxberry - <span style="color:#a23520;">'.$price['price'].' руб</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: ';
								$addtxt.=($val['DeliveryPeriod']+2).' дня)';
								$addtxt.='<br>'.$val['Name'].' '.$val['Address'];
								$addtxt.='</span> </label>';
								$DeliveryPeriod = $val['DeliveryPeriod'];
							}
						}
						$price['price'] = $price['price'] + 159;
						$iddeliv = $specdelivery['iddeliv'];
						$Code = 'c4';
						$addtxt.='<label class="radio specdeliv specdelivcode" style="display: block;"> <input type="radio" name="type_arrive" class="delivery_select" ';
						if ($specdelivery['iddeliv']==$ORDER_DATA['type_arrive'] && $Code==$ORDER_DATA['box_type']) $addtxt.=' checked="checked" ';
						$addtxt.='required="" value="'.$iddeliv.'" data-val="'.$Code.'"> <b>Доставка курьером Boxberry - <span style="color:#a23520;">'.$price['price'].' руб</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: ';
						$addtxt.=($DeliveryPeriod+2).' дня)';
						$addtxt.='</span> </label>';
					}
				}*/
			}
			$addtxt.='\');$(\'.specdeliv\')</script>';
		}
		
		

	}
	else if($view=='submit')
	{
		include ('order/submit.php');
	}else if ($view=='order')
	{
		include ('order/XMLgenerate.php');
	}

echo $addtxt;

function str2xml ($str)
{
	//var $tmp;
	$tmp=str_replace('&','&amp;',$str);
	$tmp=str_replace('\'','&apos;',$tmp);
	$tmp=str_replace('"','&quot;',$tmp);
	$tmp=str_replace('<','&lt;',$tmp);
	$tmp=str_replace('>','&gt;',$tmp);
	return $tmp;
}

function txt2xml($zzz) {
	$f[0]='<';$r[0]='&lt;';
	$f[1]='>';$r[1]='&gt;';
	$f[2]='\'';$r[2]='&apos;';
	$f[3]='"';$r[3]='&quot;';
	$zzz=str_replace('&','&amp;',$zzz);
	$zzz=str_replace($f,$r,$zzz);
	return $zzz;
}





?>
<?php 

$boxb_text = "";
$boxb_xml = "";
$specdelivery['delivtype'] = 0;

if ($ORDER_DATA['type_arrive'] > 1000) {
		//                0       1      2         3         4         5            6       7
		$sql = 'SELECT iddeliv,idcity,delivtype,delivtime,delivname,delivaddress,defcost,speccode FROM leo_delivery WHERE iddeliv='.$ORDER_DATA['type_arrive'];
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
			{  //Доставка TopDelivery  ПВЗ
				$soap = new SoapClient('http://is.topdelivery.ru/api/soap/w/1.2/?WSDL', array('login'=>"tdsoap",'password'=>"fc7a00f11c1bfa9f5b69e0be9117738e"));
				$speccode = explode("-", $r['speccode']);
				$regionId = $speccode[0];
				$cityId = $speccode[1];
				
				if ($ORDER_DATA['box_type'] == 'c5') {
					
					
					
											//Стоимость доставки
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
												$price_box = $data->calcOrderCosts->delivery.' руб.';
												$price_box_xml = $data->calcOrderCosts->delivery;
											/*
												echo '<label class="radio specdeliv specdelivcode" style="display: block;"> <input type="radio" name="type_arrive" class="delivery_select" required="" value="'.$iddeliv.'" data-val="'.$key.'"> <b>Пункт выдачи заказов Top Delivery - <span style="color:#a23520;">'.$price.' руб.</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: ';
												echo '22 дня'; echo ')';
												//echo $r['speccode'];
												echo '<br>'.$val;
												echo '</span> </label>';*/
												//echo "1111111111111";
												$boxb_text .= '<b>Доставка курьером Top Delivery - <span style="color:#a23520;">'.$price_box.'</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: ';
												
												$sql = "SELECT *  FROM `leo_delivery` WHERE `delivtype` = 5 AND `speccode` LIKE '".$speccode[0]."-".$speccode[1]."'";
												$command=Yii::app()->db->createCommand($sql);
												$s1=$command->query();
												if (sizeof($s1) == 0) {
													$boxb_text .= 'не определено';
												} else {
													foreach($s1 as $r1);
													$boxb_text .= $r1['delivtime'];
												}
												$boxb_text .= ')';
												//$boxb_text .= '<br>'.$citiall;
												$boxb_text .= '</span> ';
												if ($price_box_xml > 0)
													$boxb_xml = '<engitems><engitem><id>2337429731</id><name>Доставка курьером Top Delivery</name><price>'.$price_box_xml.'</price><fundid>1</fundid></engitem></engitems>';
												else $boxb_xml = '';
												//echo $boxb_text;
											}
					
					
					
				} else {
					
					
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
					//$citiall = array();
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
										$citiall = "г.".$cityName.", ".$cityAddress;
										if ($ORDER_DATA['box_type'] == $v2->id) {
											
											
											
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
												$price_box = $data->calcOrderCosts->delivery.' руб.';
												$price_box_xml = $data->calcOrderCosts->delivery;
											/*
												echo '<label class="radio specdeliv specdelivcode" style="display: block;"> <input type="radio" name="type_arrive" class="delivery_select" required="" value="'.$iddeliv.'" data-val="'.$key.'"> <b>Пункт выдачи заказов Top Delivery - <span style="color:#a23520;">'.$price.' руб.</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: ';
												echo '22 дня'; echo ')';
												//echo $r['speccode'];
												echo '<br>'.$val;
												echo '</span> </label>';*/
												//echo "1111111111111";
												$boxb_text .= '<b>Пункт выдачи Top Delivery - <span style="color:#a23520;">'.$price_box.'</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: ';
												
												$sql = "SELECT *  FROM `leo_delivery` WHERE `delivtype` = 5 AND `speccode` LIKE '".$speccode[0]."-".$speccode[1]."'";
												$command=Yii::app()->db->createCommand($sql);
												$s1=$command->query();
												if (sizeof($s1) == 0) {
													$boxb_text .= 'не определено';
												} else {
													foreach($s1 as $r1);
													$boxb_text .= $r1['delivtime'];
												}
												$boxb_text .= ')';
												$boxb_text .= '<br>'.$citiall;
												$boxb_text .= '</span> ';
												if ($price_box_xml > 0)
													$boxb_xml = '<engitems><engitem><id>2337429731</id><name>ПВЗ Top Delivery</name><price>'.$price_box_xml.'</price><fundid>1</fundid></engitem></engitems>';
												else $boxb_xml = '';
												//echo $boxb_text;
											}
											
											
											
										}
									}
								}
							}
						}
					}
					
					
					
				}
				
			}
			
			
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
					foreach ($pvz AS $key=>$val) {
						if ($ORDER_DATA['box_type'] != 'c4') {
							if (!in_array($val['Code'], $arr)) {
								$arr[] = $val['Code'];
								if ($ORDER_DATA['box_type'] == $val['Code']) {
									$boxb_text .= '<b>Пункт выдачи Boxberry - <span style="color:#a23520;">'.$price['price'].' руб</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: ';
									$boxb_text .= ($val['DeliveryPeriod']+2).' дня';
									$boxb_text .= ')';
									$boxb_text .= '<br>'.$val['Name'].' '.$val['Address'];
									$boxb_text .= '</span> ';
									$boxb_xml = '<engitems><engitem><id>798439432</id><name>ПВЗ Boxberry</name><price>'.$price['price'].'</price><fundid>1</fundid></engitem></engitems>';
								}
							}
						} 
					}
					if ($ORDER_DATA['box_type'] == 'c4') {
						$price['price'] = $price['price'] + 159;
							$boxb_text .= '<b>Доставка курьером Boxberry - <span style="color:#a23520;">'.$price['price'].' руб</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: ';
							$boxb_text .= ($val['DeliveryPeriod']+2).' дня';
							$boxb_text .= ')';
							$boxb_text .= '</span> ';
							$boxb_xml = '<engitems><engitem><id>798439432</id><name>Экспресс-доставка Boxberry</name><price>'.$price['price'].'</price><fundid>1</fundid></engitem></engitems>';
					}
							
					/*$price['price'] = $price['price'] + 159;
					$iddeliv = $r['iddeliv'];
					$Code = 'c4';
					if ($iddeliv != 1103) {
						$boxb_text .= '<label class="radio specdeliv specdelivcode" style="display: block;"> <input type="radio" name="type_arrive" class="delivery_select" required="" value="'.$iddeliv.'" data-val="'.$Code.'"> <b>Доставка курьером Boxberry - <span style="color:#a23520;">'.$price['price'].' руб</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: ';
						$boxb_text .= ($val['DeliveryPeriod']+2).' дня';
						$boxb_text .= ')';
						$boxb_text .= '</span> </label>';
					}*/
				}
			}
		}
}

$xml='<?xml version="1.0" encoding="windows-1251"?>
<order><onlinestore_id>2</onlinestore_id>
';

$data=date("j-n-Y");
$sql = "select count(*) from shop_statistic where data='".$data."'";
$command=Yii::app()->db->createCommand($sql);
$s=$command->queryScalar();
$numb=$s+1+800;

$xml.='<number>'.$numb.'/'.$data.'</number>
<client>
<fio>'.str2xml(stripslashes($ORDER_DATA['reg_surname'].' '.$ORDER_DATA['reg_name']/*.' '.$ORDER_DATA['reg_name2']*/)).'</fio>
<phone>'.str2xml(stripslashes($ORDER_DATA['reg_phone'])).'</phone>
<mail>'.str2xml(stripslashes($ORDER_DATA['reg_email'])).'</mail>
<postal>'.stripslashes($ORDER_DATA['reg_postcode']).'</postal>
<town>'.str2xml(stripslashes($ORDER_DATA['reg_city'])).'</town>
<address>'.str2xml(stripslashes($ORDER_DATA['reg_address'])).'</address>
';

$intdosttype_id=1;
$intpaytype_id=1;
if ($ORDER_DATA['type_pay']==1) $intpaytype_id=3;//Наложенный платеж
if ($ORDER_DATA['type_pay']==2 || $ORDER_DATA['type_pay']==4) $intpaytype_id=1;//Предоплата
if ($ORDER_DATA['type_pay']==3) $intpaytype_id=2;//Наличные

//Создание строки для ТИС
if ($ORDER_DATA['type_pay']==1)$delivery_mail[$ORDER_DATA['type_arrive']].=' Наложенный платеж';
if (($ORDER_DATA['type_arrive']==2)&&($ORDER_DATA['type_pay']!=1))$delivery_mail[$ORDER_DATA['type_arrive']].=' 100% предоплата';


$myc='#ФИО#:'.stripslashes($ORDER_DATA['reg_surname']).' '.$ORDER_DATA['reg_name']/*.' '.$ORDER_DATA['reg_name2'])*/.'
#телефон 1#:'.stripslashes($ORDER_DATA['reg_phone'])/*.'
#телефон 2#:'.stripslashes($ORDER_DATA['reg_phone2'])*/.'
#e-mail#:'.stripslashes($ORDER_DATA['reg_email']).'
#почтовый индекс#:'.stripslashes($ORDER_DATA['reg_postcode']);

if ($ORDER_DATA['reg_country']==2)
	$myc.='#страна#:'.stripslashes($ORDER_DATA['reg_country_text']);
else 
	$myc.='#страна#:Россия';
$myc.='#город#:'.stripslashes($ORDER_DATA['reg_city']);

$myc.='#адрес доставки#:'.stripslashes($ORDER_DATA['reg_address']).'
#наличие#:Отправить только полностью набранный заказ. Сообщить об отсутствующих позициях
';
$myc.='#способ отправки#:';
if ($ORDER_DATA['type_arrive']<1000) {
	$myc.=$delivery_mail[$ORDER_DATA['type_arrive']];
	if ($ORDER_DATA['type_arrive']==2) $intdosttype_id=5;//Почта России
	if ($ORDER_DATA['type_arrive']==3 || $ORDER_DATA['type_arrive']==4 )$intdosttype_id=6;//Курьер
	if ($ORDER_DATA['type_arrive']==5) $intdosttype_id=1;//Самовывоз
}
else {
	
	$sql = 'SELECT delivtype,delivname,delivtime,delivaddress,defcost,speccode FROM leo_delivery WHERE iddeliv='.$ORDER_DATA['type_arrive'];
	$command=Yii::app()->db->createCommand($sql);
	$s1=$command->query();
	if (sizeof($s1) == 0)
	{
		//FIXME Что-то нужно делать если такой способ доставки не найден
	}
	foreach($s1 as $specdelivery)
	{
		if ($specdelivery['delivtype']==2){
		if ($ORDER_DATA['box_type'] == 'c4') {$myc.='Доставка курьером Boxberry по РФ при 100 % предоплате'; $intdosttype_id=2;}
			else {$myc.='Пункты выдачи Boxberry по РФ при 100 % предоплате'; $intdosttype_id=3;}
			$myc.=$boxb_text;
			/*
			//Тип доставки: указано далее
			$myc.='<b>'.$specdelivery['delivname'].' - <span style="color:#a23520;">'.$specdelivery['defcost'].' руб</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: '.$specdelivery['delivtime'].')';
			if ($specdelivery['delivaddress']!='') $myc.='<br>'.$specdelivery['delivaddress'];
			$myc.='</span>';
			*/
		}
		if ($specdelivery['delivtype']==5){
		if ($ORDER_DATA['box_type'] == 'c5') {$myc.='Доставка курьером Top Delivery по РФ при 100 % предоплате'; $intdosttype_id=9;}
			else {$myc.='Пункты выдачи Top Delivery по РФ при 100 % предоплате'; $intdosttype_id=10;}
			$myc.=$boxb_text;
		}
	}
}

if ($ORDER_DATA['reg_country'] == 2) {
	$m='Доллар';
	$g='Заказ за пределы РФ';
	$g=stripslashes($ORDER_DATA['reg_country_text']);
} else {
	$m='Рубль';
	$g='Заказ в Россию';
}

$myc.='
#способ оплаты#:'.$pay_options[$ORDER_DATA['type_pay']].'		
#государство#:'.$g.'
#валюта#:'.$m.'
#товар будет использован#:В личных целях
#комментарий#:'.stripslashes($ORDER_DATA['reg_comments']);
$myc=str_replace("\r\n",' ',$myc);
$myc=str_replace("\r",' ',$myc);
$myc=str_replace("\n",' ',$myc);
/*************************
 * Скидки скидки
**********************/
/*
$sql='SELECT MAX(t1.discount_value),t1.discount_start,t2.discount_description FROM leo_clients_discounts'.TYPE_ORDER.' AS t1 LEFT JOIN leo_discounts AS t2 ON t1.discount_id=t2.discount_id WHERE t1.client_id='.$userid.' AND t1.discount_end>CURRENT_TIMESTAMP;';
$discount=$DB->Query($sql);
$dizcount=$DB->GetRow($discount);
$discount=$dizcount[0];
if ($discount>0)
{
	$myc.=' (Коментарий сайта: скидка размером '.$discount.'% предоставлена '.$dizcount[1].' по условию '.$dizcount[2].')';
}
*/
$xml.='<comment>'.str2xml($myc).'</comment>
<send_condition>1</send_condition>
<stock_notice>1</stock_notice>
<prepay>0</prepay>
<send_type>';
if ($ORDER_DATA['type_arrive']<1000) {
	if ($ORDER_DATA['type_pay']==1) $xml.="1";
	else $xml.="2";
}
else $xml.=2;
$sub3 = "не определено!";

if ( ($specdelivery['delivtype']==2) || ($specdelivery['delivtype']==5) ) {
	
	if ($specdelivery['delivtype']==2){	
		if ( ($ORDER_DATA['type_arrive'] > 1000) && ($ORDER_DATA['box_type'] == 'c4') )  {
			$xml.='</send_type>
	<delivery_type>'.$pay_code[4].'</delivery_type>
	';
		$sub3 = $pay_code[4];
		}
		elseif ( ($ORDER_DATA['type_arrive'] > 1000) && ($ORDER_DATA['box_type'] != 'c4') )  {
			$xml.='</send_type>
	<delivery_type>'.$pay_code[5].'</delivery_type>
	';
		$sub3 = $pay_code[5];
		} else {
		$xml.='</send_type>
	<delivery_type>'.$pay_code[$ORDER_DATA['type_arrive']].'</delivery_type>
	';
		$sub3 = $pay_code[$ORDER_DATA['type_arrive']];
		}
	}
	
	if ($specdelivery['delivtype']==5){	
		if ( ($ORDER_DATA['type_arrive'] > 1000) && ($ORDER_DATA['box_type'] == 'c5') )  {
			$xml.='</send_type>
	<delivery_type>'.$pay_code[7].'</delivery_type>
	';
		$sub3 = $pay_code[7];
		}
		elseif ( ($ORDER_DATA['type_arrive'] > 1000) && ($ORDER_DATA['box_type'] != 'c5') )  {
			$xml.='</send_type>
	<delivery_type>'.$pay_code[8].'</delivery_type>
	';
		$sub3 = $pay_code[8];
		} else {
		$xml.='</send_type>
	<delivery_type>'.$pay_code[$ORDER_DATA['type_arrive']].'</delivery_type>
	';
		$sub3 = $pay_code[$ORDER_DATA['type_arrive']];
		}
	}
	
} else {
	if (($ORDER_DATA['type_arrive']==2)&&($ORDER_DATA['type_pay']!=1)) {
		$xml.='</send_type>
<delivery_type>'.$pay_code[1].'</delivery_type>
';
		$sub3 = $pay_code[1];
	} elseif (($ORDER_DATA['type_arrive']==2)&&($ORDER_DATA['type_pay']==1)) {
		$xml.='</send_type>
<delivery_type>'.$pay_code[2].'</delivery_type>
';
		$sub3 = $pay_code[2];
	} elseif ($ORDER_DATA['type_arrive']==3) {
		$xml.='</send_type>
<delivery_type>'.$pay_code[3].'</delivery_type>
';
		$sub3 = $pay_code[3];
	} elseif ($ORDER_DATA['type_arrive']==6) {
		$xml.='</send_type>
<delivery_type>'.$pay_code[6].'</delivery_type>
';
		$sub3 = $pay_code[6];
	} else {
		//самовывоз
		$xml.='</send_type>
<delivery_type>1</delivery_type>
';
		$sub3 = "не определено";
	}
}

if ($intpaytype_id>0)$xml.='<paytypeid>'.$intpaytype_id.'</paytypeid>'; 
if ($intdosttype_id>0)$xml.='<dosttypeid>'.$intdosttype_id.'</dosttypeid>';

/*************************
 * Дисконтная карта
 ***********************/
if ($ORDER_DATA['reg_discont']!=NULL) 
	$xml.='<card_number>'.str2xml($ORDER_DATA['reg_discont']).'</card_number>
';

/*************************
 * Скидки скидки
 **********************/
	/*
$sql='SELECT MAX(discount_value) FROM leo_clients_discounts'.TYPE_ORDER.' WHERE client_id='.$userid.' AND discount_end>CURRENT_TIMESTAMP;';
$discount=$DB->Query($sql);
$discount=$DB->GetRow($discount);
$discount=$discount[0];
if ($discount>0)
{
	$xml.='<discount>'.$discount.'</discount>
';
}
$xml.='<dealstep>1</dealstep>
';
*/
$xml.='<dealstep>1</dealstep>
';
$xml.='</client>';

//Прочие обязательства
if (($ORDER_DATA['type_arrive']==2)&&($ORDER_DATA['type_pay']==1))
{
	$xml.='<engitems><engitem><id>3382409562</id><name>Почта России, наложенный платеж</name><price>350</price><fundid>1</fundid></engitem></engitems>';
}
if (($ORDER_DATA['type_arrive']==2)&&($ORDER_DATA['type_pay']!=1))
{
	$xml.='<engitems><engitem><id>3243341062</id><name>Почта России, 100% предоплата</name><price>350</price><fundid>1</fundid></engitem></engitems>';
}
if (($ORDER_DATA['type_arrive']==3))
{
	$xml.='<engitems><engitem><id>970253462</id><name>Доставка курьером по Москве</name><price>250</price><fundid>1</fundid></engitem></engitems>';
}
if (($ORDER_DATA['type_arrive']==4))
{
	$xml.='<engitems><engitem><id>970253462</id><name>Доставка курьером по Екатеринбургу</name><price>190</price><fundid>1</fundid></engitem></engitems>';
}
if (($ORDER_DATA['type_arrive']>=1000))
{
	if ($specdelivery['delivtype']==2){
		$xml.=$boxb_xml;
	}
	if ($specdelivery['delivtype']==5){
		$xml.=$boxb_xml;
	}
	/*
	if (($specdelivery[0]==0)&&($specdelivery[1]=='Доставка курьером'||$specdelivery[1]=='доставка курьером'))
	{
		$xml.='<engitems><engitem><id>970253462</id><name>Доставка курьером</name><price>'.$specdelivery[4].'</price><fundid>1</fundid></engitem></engitems>';
	}else if ($specdelivery[0]==0)
	{
		$xml.='<engitems><engitem><id>970253462</id><name>Доставка курьером(x)</name><price>'.$specdelivery[4].'</price><fundid>1</fundid></engitem></engitems>';
	}
	*/
}


$xml.='
<items>
';

$total=0;
$totalves=0;
$totalob=0;

foreach ($cart_goods AS $key => $val)
{
	$sql = "select * from Goods where GoodID=".$key." GROUP BY GoodID";
	$command=Yii::app()->db->createCommand($sql);
	$r0=$command->query();
	foreach($r0 as $s0)
	{
		$shop_good_id=$key;
		$nam=$s0['GoodName'];
		$pr=$s0['Price'];
		$tot=$val*$pr;
		$total+=$tot;
		$koef=1;
		$sql = "select value  from Property where PropertyID='1755868031' and GoodID=".$shop_good_id;
		$command=Yii::app()->db->createCommand($sql);
		$r1=$command->query();
		foreach($r1 as $s1)
			$totalves+=$s1['value']*$val;

		$sql = "select value from Property where PropertyID='1755871671' and GoodID=".$shop_good_id;
		$command=Yii::app()->db->createCommand($sql);
		$r1=$command->query();
		foreach($r1 as $s1)				
			$totalob+=$s1['value']*$val*$koef;
		$addtxt.="<tr><td>$nam</td><td align=\"center\">$val</td><td align=\"center\">$pr</td><td align=\"center\">$tot</td></tr>";
	}
}

if ($total==0){
	echo 'Ваш заказ оформлен. На электронный адрес выслано письмо с подтверждением заказа.';
}

$aaddress=$ORDER_DATA['reg_postcode'].", ".$ORDER_DATA['reg_city'].", ".$ORDER_DATA['reg_address'];


			$ayear=date("Y");
			$amonth=date("m");
			$aday=date("d");
			//$aaddress=$reg_postcode.", ".stripslashes(htmlspecialchars($reg_address));
$ORDER_DATA['reg_name2'] = "";
			$sql = 'insert into manual_order (id, year, month, day, number, city, address, sum, ref, vis, fio, email, fullmoment) values (NULL, '.$ayear.', '.$amonth.', '.$aday.', '.$numb.', "'.stripslashes(htmlspecialchars($ORDER_DATA['reg_city'])).'", "'.$aaddress.'", 0, "", 1, "'.$ORDER_DATA['reg_surname'].' '.$ORDER_DATA['reg_name'].' '.$ORDER_DATA['reg_name2'].'", "'.$ORDER_DATA['reg_email'].'", '.time().')';
			$command=Yii::app()->db->createCommand($sql);
			$command->execute();
			
			$sql = "select id from manual_order where month=".$amonth." and day=".$aday." and year=".$ayear." and number=".$numb;
			$command=Yii::app()->db->createCommand($sql);
			$zozo=$command->query();
			foreach($zozo as $soso);

			foreach ($cart_goods AS $key => $val)
				{
					$sql = "select * from Goods where GoodID=".$key." GROUP BY GoodID";
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
						$xml.='<price>'.$s0['Price'].'</price><fundid>1</fundid><addnds>0</addnds>';
						$s0['GoodName']=$s0['GoodName'];
						$s0['GoodName']=ltrim($s0['GoodName']);
						$s0['GoodName']=rtrim($s0['GoodName']);
						$xml.='<fullname>'.str2xml($s0['GoodName']).'</fullname>';
						$xml.='</item>';
					}
				}



$xml.='</items>
';
$xml.='</order>
';

$addtxt='
<div style="max-width: 900px; margin: 0 auto; padding: 0 50px 0 50px;">
<!--<p class="zag">Оформление заказа</p>--><p><b>Номер Вашего заказа '.$numb.'/'.$data.'</b>
<p>Заявка на Ваш заказ будет обработана в ближайшее время.</p>
<p>На указанный Вами e-mail выслано письмо с информацией о заказе.</p>
<p><strong>Внимание!</strong> Чтобы не создавать Вам лишнее беспокойство, наши менеджеры свяжутся с Вами лишь в тот момент, когда будет получена информация о наличии вашего товара на складе.</p>
</div>';

//Отправка письма покупателю
			$mail=$ORDER_DATA['reg_email'];
			$headers = "From: Miadolla.Ru <shop@miadolla.ru> \r\n";
			$headers2 = "From: Miadolla.Ru <shop@miadolla.ru> \r\n";
			$su='Информация о розничном заказе';
			$su2="Розничный заказ ".$numb."/".$data." — ".stripslashes($ORDER_DATA['reg_name'])." ".stripslashes($ORDER_DATA['reg_surname']);
			$su = iconv("utf-8", "windows-1251", $su);
			$su2 = iconv("utf-8", "windows-1251", $su2);
			$subj ='=?windows-1251?B?'.base64_encode($su).'?=';
			$subj2 ='=?windows-1251?B?'.base64_encode($su2).'?=';
			$headers.= "Content-Type: text/html; charset=Windows-1251\r\n";
			$headers2.= "Content-Type: text/html; charset=Windows-1251\r\n";
			$headers.= "MIME-Version: 1.0\r\n";
			$headers2.= "MIME-Version: 1.0\r\n";

$mailbody='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html><head><title>miadolla.ru — информация о розничном заказе</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head><style>
h1{font-family:Arial, Helvetica, sans-serif;font-size:16px;font-weight:bold;}
h2{font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;}
p{font-family:Arial, Helvetica, sans-serif;font-size:12px;}c11{font-size:11px;}
td{font-family:Arial, Helvetica, sans-serif;font-size:11px;padding:5px;}
.td1{background-color:#DDDDDD;}.td2{background-color:#EEEEEE;}.td3{background-color:#F6F6F6;}
</style><body><h1>Информация о Вашем розничном заказе в «Miadolla».</h1>
<p>Здравствуйте, '.stripslashes($ORDER_DATA['reg_name']).' '.stripslashes($ORDER_DATA['reg_surname']).'!</p>
<p>Спасибо за заказ! Спасибо, что выбрали нас!</p>
Ваш e-mail был указан при оформление розничного заказа в интернет-магазине <a href="http://miadolla.ru">miadolla.ru</a>.<br />
Номер вашей заявки: <b>'.$numb.'/'.$data.'</b>.</p>
<p><b>Важно!</b><br />Пожалуйста сохраните этот номер, в случае возникновения проблем с розничным заказом он будет необходим для идентификации.</p>
';

if(($ORDER_DATA['type_arrive']==1)||($ORDER_DATA['type_arrive']==2))
{
	$mailbody.='<p>Обращаем ваше внимание, что мы не будем Вас беспокоить без повода, поэтому номер посылки мы
		вышлем лишь тогда, когда эта информация появляется у нас. По этому номеру Вы сможете отслеживать путь прохождения посылки</p>
		<p>При наличии всего товара в наличии заказ формируется за 2-3 дня и через 3-4 дня (2 раза в неделю) сдается  в почтовую
		компанию. Еще 3-5 дней уходит у почтовой компании на оформление посылки и сдачу ее почте России. При наличии всего товара мы
		сможем сообщить Вам номер вашей посылки примерно через 12-20 дней после принятия вашего заказа. Если часть товара отсутствует
		в наличии, то она заказывается под Ваш заказ. В этом случае с срок отправки заказа увеличивается еще на 5-30 дней.</p>
	';
} elseif (($ORDER_DATA['type_arrive']==3)||($ORDER_DATA['type_arrive']==4)) {
	/*$mailbody.='<p>Обращаем Ваше внимание на то, что курьер позвонит Вам, как только весь товар будет собран
	и готов к отправке. Обычно это происходит на 3-5 день после заказа при наличии всего товара и на 6-30 день при необходимости
	заказать и привезти товар с оптового склада для Вас.</p>
	';*/
	$mailbody.='';
}

$mailbody.='<br /><h2>Состав розничного заказа:</h2><table>
<tr><td class="td1"><b>Наименование</b></td><td class="td1"><b>Цена</b></td><td class="td1"><b>Количество</b></td><td class="td1"><b>Стоимость</b></td></tr>
';

$mailbody2='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html><head><title>miadolla.ru — информация о розничном заказе</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head><style>
h1{font-family:"Courier New", Courier, monospace;font-size:26px;font-weight:bold;}
h2{font-family:"Courier New", Courier, monospace;font-size:20px;font-weight:bold;}
p{font-family:"Courier New", Courier, monospace;font-size:18px;}
c11{font-size:11px;}
td{font-family:"Courier New", Courier, monospace;font-size:16px;padding:5px;}
.td1{background-color:#DDDDDD;}
.td2{background-color:#EEEEEE;}
.td3{background-color:#F6F6F6;}
</style><body><h2>'.$numb.'/'.$data." — ".stripslashes($ORDER_DATA['reg_name']).' '.stripslashes($ORDER_DATA['reg_surname']).'</h1>
';
$yeap1='<p><strong>Состав розничного заказа:</strong></p>
<table>
<tr><td class="td1"><b>Наименование</b></td><td class="td1"><b>Цена</b></td><td class="td1"><b>Количество</b></td><td class="td1"><b>Стоимость</b></td></tr>
';
$lk=2;
$sumpr=0;
$totalves=0;
$totalob=0;

foreach ($cart_goods AS $key => $val)
			{
					$sql = "select * from Goods where GoodID=".$key." GROUP BY GoodID";
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
			
$sql = 'update manual_order set sum='.$sumpr.' where id='.$soso['id'];
$command=Yii::app()->db->createCommand($sql);
$command->execute();


$mailbody.='<tr><td class="td1"><b>Сумма заказа:</b></td><td class="td1" colspan="3" align="center"><b>'.$sumpr.' р.</b></td></tr>';
//$mailbody.='<tr><td class="td3"><b>Примерный вес заказа, не более *</b></td><td class="td3" colspan="3" align="center">'.round($totalves,4).' кг</td></tr>';
//$mailbody.='<tr><td class="td3"><b>Примерный объем заказа, не более</b></td><td class="td3" colspan="3" align="center">'.round($totalob,4).' л</td></tr>';

$yeap1.='<tr><td class="td1"><b>Сумма заказа:</b></td><td class="td1" colspan="3" align="center"><b>'.$sumpr.' р.</b></td></tr>';
//$yeap1.='<tr><td class="td3"><b>Примерный вес заказа, не более *</b></td><td class="td3" colspan="3" align="center">'.round($totalves,4).' кг</td></tr>';
//$yeap1.='<tr><td class="td3"><b>Примерный объем заказа, не более</b></td><td class="td3" colspan="3" align="center">'.round($totalob,4).' л</td></tr></table><br /><br />* Примерный вес заказа указан без упаковки.';
/*************************
 * Скидки скидки
**********************/
/*
$sql='SELECT MAX(discount_value) FROM leo_clients_discounts'.TYPE_ORDER.' WHERE client_id='.$userid.' AND discount_end>CURRENT_TIMESTAMP;';
$discount=$DB->Query($sql);
$discount=$DB->GetRow($discount);
$discount=$discount[0];
if ($discount>0)
{
	$discounttext.='<tr><td class="td1" colspan="4">На данный заказ предоставлена скидка в размере '.$discount.'%. Скидка не распространяется на услуги доставки и "товары месяца". Сумма заказа со скидкой и стоимостью доставки будет выслана по электронной почте после расчета нашим менеджером.</td></tr>';
}
$mailbody.=$discounttext;
$yeap1.=$discounttext;
*/
$mailbody.='</table><br />';
$mailbody.='<h2>Дополнительные данные:</h2><table>';
$yeap2='<h2>Дополнительные данные:</strong></h2><table>';


$phones=NULL;
if($ORDER_DATA['reg_phone']!='') $phones=stripslashes($ORDER_DATA['reg_phone']);

$mailbody.='<tr><td class="td2"><b>ФИО</b></td><td class="td2">'.stripslashes($ORDER_DATA['reg_surname'].' '.$ORDER_DATA['reg_name']).'</td></tr>
			<tr><td class="td3"><b>E-mail</b></td><td class="td3">'.stripslashes($mail).'</td></tr>
<tr><td class="td3"><b>Телефоны</b></td><td class="td3">'.stripslashes($phones).'</td></tr>
<tr><td class="td2"><b>Адрес</b></td><td class="td2">'.stripslashes($ORDER_DATA['reg_postcode'].', '.$ORDER_DATA['reg_city'].', '.$ORDER_DATA['reg_address']).'</td></tr>
<tr><td class="td3"><b>Комментарии</b></td><td class="td3">'.stripslashes($ORDER_DATA['reg_comments']).'</td></tr>
<tr><td class="td2"><b>Наличие</b></td><td class="td2">Отправить только полностью набранный заказ.<br />Сообщить об отсутствующих позициях</td></tr>
<tr><td class="td3"><b>Способ отправки</b></td><td class="td3">';

if ($ORDER_DATA['type_arrive']<1000)
{
	$mailbody.=$delivery_options[$ORDER_DATA['type_arrive']];
}else {
	if ($specdelivery['delivtype']==2){
		//if ($ORDER_DATA['box_type'] == 'c4') $mailbody.='Доставка курьером Boxberry по РФ при 100 % предоплате';
		//else $mailbody.='Пункты выдачи Boxberry по РФ при 100 % предоплате';
		$mailbody.=$boxb_text;
		/*
		//Тип доставки: указано далее
		$mailbody.='<b>'.$specdelivery['delivname'].' - <span style="color:#a23520;">'.$specdelivery['defcost'].' руб</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: '.$specdelivery['delivtime'].')';
		if ($specdelivery['delivaddress']!='') $mailbody.='<br>'.$specdelivery['delivaddress'];
		$mailbody.='</span>';
		*/
	}
	if ($specdelivery['delivtype']==5){
		$mailbody.=$boxb_text;
	}
	
}

$mailbody.='</td></tr>';
$mailbody.='<tr><td class="td3"><b>Способ оплаты</b></td><td class="td3">'.$pay_options[$ORDER_DATA['type_pay']].'</td></tr>';
//$mailbody.='<tr><td class="td3"><b>Государство</b></td><td class="td3">'.$g.'</td></tr>';
//if($country_arrive>1) $mailbody.='<tr><td class="td3"><b>Валюта оплаты</b></td><td class="td3">'.$m.'</td></tr>';
$mailbody.='</table><br /><br />';
$mailbody.='<br /><h2>Обратная связь</h2><p>
В случае возникновения каких-то вопросов, связанных с розничным заказом, напишите нам электронное письмо на адрес <a href="mailto:shop@miadolla.ru">shop@miadolla.ru</a>. В письме укажите номер вашей заявки - <b>'.$numb.'/'.$data.'</b>.</p>
<p>Также с нами можно связаться по телефону (495) 603-8763, 603-8759.</p></body></html>';

$yeap2.='<tr><td class="td2"><b>ФИО</b></td><td class="td2">'.stripslashes($ORDER_DATA['reg_surname'].' '.$ORDER_DATA['reg_name']).'</td></tr>
<tr><td class="td3"><b>E-mail</b></td><td class="td3">'.stripslashes($mail).'</td></tr>
<tr><td class="td3"><b>Телефоны</b></td><td class="td3">'.stripslashes($phones).'</td></tr>
<tr><td class="td2"><b>Адрес</b></td><td class="td2">'.stripslashes($ORDER_DATA['reg_postcode'].', '.$ORDER_DATA['reg_city'].', '.$ORDER_DATA['reg_address']).'</td></tr>
<tr><td class="td3"><b>Комментарии</b></td><td class="td3">'.stripslashes($ORDER_DATA['reg_comments']).'</td></tr>
<tr><td class="td3"><b>Способ отправки</b></td><td class="td3">';
//<tr><td class="td2"><b>Наличие</b></td><td class="td2">'.$a1.'</td></tr>

if ($ORDER_DATA['type_arrive']<1000)
{
	$yeap2.=$delivery_options[$ORDER_DATA['type_arrive']];
}else {
	if ($specdelivery['delivtype']==2){
		//if ($ORDER_DATA['box_type'] == 'c4') $yeap2.='Доставка курьером Boxberry по РФ при 100 % предоплате';
		//else $yeap2.='Пункты выдачи Boxberry по РФ при 100 % предоплате';
		$yeap2.=$boxb_text;
		/*
		//Тип доставки: указано далее
		$yeap2.='<b>'.$specdelivery['delivname'].' - <span style="color:#a23520;">'.$specdelivery['defcost'].' руб</span></b><br><span style="font-size: 8pt/10pt;color: grey;">(срок доставки: '.$specdelivery['delivtime'].')';
		if ($specdelivery['delivaddress']!='') $yeap2.='<br>'.$specdelivery['delivaddress'];
		$yeap2.='</span>';
		*/
	}
	if ($specdelivery['delivtype']==5){
		$yeap2.=$boxb_text;
	}
}


$yeap2.='</td></tr>';
$yeap2.='<tr><td class="td3"><b>Способ оплаты</b></td><td class="td3">'.$pay_options[$ORDER_DATA['type_pay']].'</td></tr>';
//$yeap2.='<tr><td class="td3"><b>Государство</b></td><td class="td3">'.$g.'</td></tr>';
//if($country_arrive>1) $yeap2.='<tr><td class="td3"><b>Валюта оплаты</b></td><td class="td3">'.$m.'</td></tr>';
$yeap2.='</table>';

$mailbody2.=$yeap2.'<br /><br />'.$yeap1.'</body></html>';


if (strcmp($mail, "khaziyev_m@sb-service.ru") === 0) {
	echo "<textarea>".$xml."</textarea>";
	echo "<br />";
	echo $mailbody;
	echo "<br />";
	echo $mailbody2;
	echo "<br />";
	echo $sub3;
	$mailbody = iconv("utf-8", "windows-1251", $mailbody);
	$headers = iconv("utf-8", "windows-1251", $headers);
	mail($mail, $subj, $mailbody, $headers);
	exit;
}


$subj2.=' ('.$sub3.')';
if (!defined('___NOMAIL___'))
{
			$mailbody = iconv("utf-8", "windows-1251", $mailbody);
			$mailbody2 = iconv("utf-8", "windows-1251", $mailbody2);
			
			$headers = iconv("utf-8", "windows-1251", $headers);
			$headers2 = iconv("utf-8", "windows-1251", $headers2);
	
			mail($mail, $subj, $mailbody, $headers);
			//mail("khaziyev_m@sb-service.ru", $subj, $mailbody, $headers);

			//$orders_email = Yii::app()->params['orders_email'];
			//$orders_email = "khaziyev_m@sb-service.ru";
			$orders_email = "shop@igla.ru,khaziyev_m@sb-service.ru";
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
}


$xml = iconv("utf-8", "windows-1251//TRANSLIT", $xml);

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
			
			$sql = "insert into shop_statistic (id, data, fullmoment, numb_at_day, xml) values (NULL, \"".$data."\", ".$tim.", ".$numb.", \"".$xml2."\")";
			$command=Yii::app()->db->createCommand($sql);
			$command->execute();
			
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

?>
<?php
$total = 0;
$nonal = 0;
/*$sql = 'SELECT t1.count,t2.price FROM leo_cart'.TYPE_ORDER.' AS t1, tis_dep AS t2 WHERE t1.id_detail=t2.code AND t2.dep_id=' . $_city [3] . ' AND t1.client_id='.$userid.' AND t1.count>0 AND t2.price>0 AND t2.sizes>0;';
$s = $DB->Query ( $sql );
while ( $r = $DB->GetRow ( $s ) ) {
	if (! is_numeric ( $r [1] ) || ! is_numeric ( $r [2] ))
		continue;
	$tot = $r [0] * $r [1];
	$total += $tot;
}*/
$addtxt .= "<div style='max-width: 900px; margin: 0 auto; padding: 0 50px 0 50px;'>";
if ($ORDER_DATA['reg_ordtype'] == 1) {
	$addtxt .= '<p style="color:#FF0000">Вы указали, что товар будет использован в коммерческих целях. Обращаем Ваше внимание, что оптовыми поставками занимается фирма «Гамма». Настоятельно рекомендуем посетить <a href="http://www.firma-gamma.ru/" style="color:red;font-weight:bold">сайт компании</a> и ознакомиться с условиями работы и оптовыми ценами. Если Вы продолжите оформление заказа на сайте «Леонардо», то Ваш заказ будет посчитан по розничным ценам хобби-гипермаркета «Леонардо».</p>';
}// elseif ($total > 5000) {
	// $addtxt.='<p style="color:#FF0000">Сумма Вашего заказа превысила 5000 рублей. Обращаем Ваше внимание, что оптовыми поставками занимается фирма «Гамма». Настоятельно рекомендуем посетить <a href="http://www.firma-gamma.ru/" style="color:red;font-weight:bold">сайт компании</a> и ознакомиться с условиями работы и оптовыми ценами. Если Вы продолжите оформление заказа на сайте «Иголочки», то Ваш заказ будет посчитан по розничным ценам «Иголочки».</p>';
//}
function txt2html($str) {return(stripslashes ( htmlspecialchars($str)));}
$addtxt .= "<p>Проверьте правильность введенных данных.</p>";

$addtxt .= '	<div class="zakaz-str"><div class="zakaz-str-name">Фамилия</div>
    <div class="zakaz-str-input"><strong>'.txt2html($ORDER_DATA['reg_surname']).'</strong></div></div>
	<div class="zakaz-str"><div class="zakaz-str-name">Имя</div>
    <div class="zakaz-str-input"><strong>'.txt2html($ORDER_DATA['reg_name']).'</strong></div></div>
    <div class="zakaz-str"><div class="zakaz-str-name">Отчество</div>
    <div class="zakaz-str-input"><strong>'.txt2html($ORDER_DATA['reg_name2']).'</strong></div></div>
    <div class="zakaz-str"><div class="zakaz-str-name">Телефон</div>
    <div class="zakaz-str-input"><strong>'.txt2html($ORDER_DATA['reg_phone']).'</strong></div></div>
    <div class="zakaz-str"><div class="zakaz-str-name">Доп. телефон</div>
    <div class="zakaz-str-input"><strong>'.txt2html($ORDER_DATA['reg_phone2']).'</strong></div></div>
    <div class="zakaz-str"><div class="zakaz-str-name">E-mail</div>
    <div class="zakaz-str-input"><strong>'.txt2html($ORDER_DATA['reg_email']).'</strong></div></div>';
if ($ORDER_DATA['type_arrive'] == 1)
	$addtxt .= '    <div class="zakaz-str"><div class="zakaz-str-name">Почтовый индекс</div>
    <div class="zakaz-str-input"><strong>'.txt2html($ORDER_DATA['reg_postcode']).'</strong></div></div>';
$addtxt .= '    <div class="zakaz-str"><div class="zakaz-str-name">Страна, город</div>
    <div class="zakaz-str-input"><strong>'.txt2html($ORDER_DATA['reg_city']).'</strong></div></div>
    <div class="zakaz-str"><div class="zakaz-str-name">Адрес доставки</div>
    <div class="zakaz-str-input"><strong>'.txt2html($ORDER_DATA['reg_address']).'</strong></div></div>
    <div class="zakaz-str"><div class="zakaz-str-name">№ дисконтной карты</div>
    <div class="zakaz-str-input"><strong>'.txt2html($ORDER_DATA['reg_discont']).'</strong></div></div>
    <div class="zakaz-str"><div class="zakaz-str-name">Дополнительно</div>
    <div class="zakaz-str-input"><strong>'.txt2html($ORDER_DATA['reg_comments']).'</strong></div></div>';
if ($ORDER_DATA['reg_nalichie'] == 1)
	$a1 = "Отправить только полностью набранный заказ";
else
	$a1 = "Отправить имеющуюся в наличии часть заказа, но не менее половины";
if ($ORDER_DATA['reg_nalichie2'] == 1)
	$a2 = "<br />Сообщить об отсутствующих позициях";
else
	$a2 = NULL;
if ($ORDER_DATA['type_arrive'] == 1)
	$a3 = "Ценной посылкой с наложенным платежом";
elseif ($ORDER_DATA['type_arrive'] == 3)
	$a3 = "Курьером по Москве / Московской области";
elseif ($ORDER_DATA['type_arrive'] == 2)
	$a3 = "Ценной посылкой со 100% предоплатой";
elseif ($ORDER_DATA['type_arrive'] == 4)
	$a3 = "Курьером по Екатеринбургу";
else
	$a3 = "не определено";
	// elseif($type_arrive==4) $a3="Через почтоматы г. Москва со 100% предоплатой";
	// elseif($type_arrive==5) $a3="Через почтоматы г. Москва с оплатой на месте";
//if ($country_arrive == 1)
	$g = 'Заказ в Россию';
//else
//	$g = 'За пределы РФ';
//if ($reg_money == 1)
	$m = 'Рубль';
//elseif ($reg_money == 2)
//	$m = 'Доллар';
//else
//	$m = 'Евро';
if ($ORDER_DATA['reg_ordtype'] == 1)
	$ce = 'В коммерческих целях';
else
	$ce = 'В личных целях';
$addtxt .= '<div class="zakaz-str"><div class="zakaz-str-name">Наличие:</div>
    <div class="zakaz-str-input"><strong>' . $a1 . $a2 . '</strong></div></div>
    <div class="zakaz-str"><div class="zakaz-str-name">Способ отправки:</div>
    <div class="zakaz-str-input"><strong>' . $a3 . '</strong></div></div>';
// $addtxt.='<tr><td><b>Государство</b></td><td>'.$g.'</td></tr>';
$country_arrive = 0;
if ($country_arrive > 1)
	$addtxt .= '<p><b>Валюта оплаты</b> ' . $m . '</p>';

$addtxt .= '<table width="100%" cellspacing="2" cellpadding="5" border="0">';
$addtxt .= '<tr class="table_cell"><td align="center">Наименование</td><td align="center">Кол-во</td><td align="center">Цена</td><td align="center">Стоимость</td></tr>';

$total = 0;
$totalves = 0;
$totalob = 0;
/*$sql = 'SELECT t1.count,t2.price,t4.goodname,t3.detailname FROM leo_cart'.TYPE_ORDER.' AS t1 LEFT JOIN tis_dep AS t2 ON t1.id_detail=t2.code AND t2.dep_id=' . $_city [3] . ' LEFT JOIN leo_details AS t3 ON t1.id_detail=t3.id_detail LEFT JOIN leo_goods AS t4 ON t3.id_good=t4.id_good WHERE t1.count>0 AND t2.price>0 AND t2.sizes>0 AND t1.client_id='.$userid.';';
$s = $DB->Query ( $sql );
while ( $r = $DB->GetRow ( $s ))
{ 

	if (! is_numeric ( $r [0] )) continue;
	if (! is_numeric ( $r [1] )) continue;
		// 0 1 2 3 4
		// $s=$DB->Query('SELECT SQL_NO_CACHE id,name_2,price,weight,volume FROM panna_nabor WHERE id='.$mas_goods[$e].';');
		// $s=mysql_query('SELECT SQL_NO_CACHE t1.code,t1.price,t2.f_goods_all FROM tis_dep AS t1 LEFT JOIN tis_goods_v AS t2 ON t1.code=t2.f_goods_id WHERE t1.dep_id=52 AND t1.code='.$key.';');
		// if (mysql_num_rows($s)==0) continue;
		// $r=mysql_fetch_row($s);
	$nam = $r [2] . ' ' . $r [3];
	$tot = $r [0] * $r [1];
	$total += $tot;
	$koef = 1;
	// $totalves+=$r[3]*$mas_cols[$e];
	// $totalob+=$r[4]*$mas_cols[$e];
	$addtxt .= "<tr><td>$nam</td><td align=\"center\">" . $r [0] . "</td><td align=\"center\">" . $r [1] . "</td><td align=\"center\">$tot</td></tr>";
}*/
$dost = '';
$dost_cena = '';

// Расчет доставки. Во временном варианте не используется.

// $total=$total;
// $dost_cena=$dost_cena;
// #######################################
$addtxt .= '<tr><td align="right">&nbsp;</td><td colspan="3" class="table_cell" align="center"><b>Стоимость заказа: ' . $total . '</b></td></tr>';
// if(($type_arrive==1)||($type_arrive==2))$addtxt.='<tr><td align="right"><b>Ориентировочная стоимость почтовой доставки: </b></td><td colspan="3" class="table_cell" align="left"><b> '.$dost_cena.'</b></td></tr>';

$addtxt .= '</table>';
/*
 * if(($type_arrive==1)||($type_arrive==2))if($dost_cena>=$total && $dost_cena!='<b>не определена.</b>') { $addtxt.="<p style=\"color:red;font-size:14px;\">Стоимость заказа меньше или равна стоимости доставки. Рекомендуем добавить товары в корзину, чтобы покупка была более выгодной.</p>"; }
 */

/*************************
 * Скидки
**********************/
/*$sql='SELECT MAX(discount_value) FROM leo_clients_discounts'.TYPE_ORDER.' WHERE client_id='.$userid.' AND discount_end>CURRENT_TIMESTAMP;';
$discount=$DB->Query($sql);
$discount=$DB->GetRow($discount);
$discount=$discount[0];
if ($discount>0)
{
	$addtxt.='<p>На данный заказ предоставлена скидка в размере <b style="color:red;">'.$discount.'%</b> на все товары, кроме "товаров месяца".</p>';
}*/




if ($ORDER_DATA['type_arrive'] == 1)
	$addtxt .= '<p class="font-tahoma-red-11-13">За осуществление денежного перевода Почта России дополнительно взимает 7% от стоимости наложенного платежа.</p>';
	
	// if($nonal==1) $addtxt.='<p style="color:red">Внимание, возможно в Вашем заказе присутствует мерный заказ. Обратите внимание, что для мерного товара цена указана за сантиметр. Рекомендуем перед оформлением заказа перепроверить количество.</p>';

$addtxt .= '<p>Я, <b>'.$ORDER_DATA['reg_surname'].' '.$ORDER_DATA['reg_name'].' '.$ORDER_DATA['reg_name2'].'</b>, подтверждаю заказ товаров для рукоделия на сумму <b>'.$total.' руб.</b> по адресу <b>'.$ORDER_DATA['reg_postcode'].', '.$ORDER_DATA['reg_city'].', '.$ORDER_DATA['reg_address'].'</b>. Оплату заказа и доставки гарантирую. Адрес указан правильно. Цены и количество товара в заказе мною проверено и соответствуют моему заказу.</b></p>';

$addtxt .= $dost;

$addtxt .= '<p>С тарифами на услуги доставки можно ознакомиться в разделе <a href="/arrive/" target="_blank">доставка</a>.</p>';

function urlmail($stroka) {
	$ln = strlen ( $stroka );
	$mailok = 0;
	for($i = 0; $i < $ln; $i ++)
		if ($stroka [$i] == '@')
			$mailok = 1;
	return ($mailok);
}
if ($ORDER_DATA['reg_phone'] != '')$phone1 = 1;
else $phone1 = 0;
if ($ORDER_DATA['reg_phone2'] != '')$phone2 = 1;
else $phone2 = 0;
$allphone = $phone1 + $phone2;
if (($ORDER_DATA['reg_email'] != '') && (urlmail ( $ORDER_DATA['reg_email'] )))
	$mailok = 1;
else
	$mailok = 0;
if (($allphone == 0) && ($mailok == 0)) {
	$addtxt .= '<span class="font-tahoma-darkedred-11-13"><b>Внимание!</b> Настоятельно рекомендуем Вам оставить контактную информацию (e-mail или телефон) для того, чтобы наши менеджеры могли связаться с Вами. В противном случае по усмотрению менеджеров отправка заказа может быть не выполнена. Если заказ все-таки будет отправлен, то мы не гарантируем Вам успешность доставки.</span>';
}
if (($allphone == 0) && ($mailok == 1))
	$addtxt .= '<span class="font-tahoma-darkedred-11-13"><b>Внимание!</b> Настоятельно рекомендуем Вам оставить контактные телефоны для того, чтобы наши менеджеры могли связаться с Вами. Если мы не сможем с Вами связаться по электронной почте, то по усмотрению менеджеров отправка заказа может быть не выполнена. Если заказ все-таки будет отправлен, то мы не гарантируем Вам успешность доставки.</span>';
if (($allphone > 0) && ($mailok == 0)&&($ORDER_DATA['type_arrive'] != 3)&&($ORDER_DATA['type_arrive'] != 4))
	$addtxt .= '<span class="font-tahoma-darkedred-11-13"><b>Внимание!</b> Поле e-mail не заполнено или заполнено неверно. Настоятельно рекомендуем Вам оставить адрес электронной почты для того, чтобы наши менеджеры могли связаться с Вами. Если мы не сможем с Вами связаться по телефону, то по усмотрению менеджеров отправка заказа может быть не выполнена. Если заказ все-таки будет отправлен, то мы не гарантируем Вам успешность доставки.</span>';
if (($allphone == 1) && ($mailok == 0))
	$addtxt .= '<span class="font-tahoma-darkedred-11-13"><b>Внимание!</b> Рекомендуем Вам оставить два контактных телефона для того, чтобы наши менеджеры могли иметь более надежную возможность связаться с Вами.</span>';
$addtxt .= '<input type="button" class="btn-xs btn-danger btn btn-primary" value="Продолжить выбор товара" onclick="window.location.href=\'/\';">';
$addtxt .= '<form action="" method="post" style="display:inline-block;">';// . $hiddentypes;
$addtxt .= '<input type="submit" class="btn-xs btn-danger btn btn-primary" value="Изменить данные"></form>';
$addtxt .= '<form action="" method="post" style="display:inline-block;"><input type="hidden" name="submit" value="order" />';
$addtxt .= '<input type="submit" class="btn btn-primary btn-success" value="Подтвердить заказ" style="cursor:pointer;"></form>';

$addtxt .= "</div>";

?>

<?php if(isset($rows)): ?>
<?php

	$addtxt="<div class=\"main_text\"><script type=\"text/javascript\">
					function vacancyresize(){
						var vacheight=100;
						$('.vacancy-text').each(function(){
							var tempheight=$(this).height();
							if (vacheight<tempheight){vacheight=tempheight}
						});
						//$('.vacancy-text').height(vacheight);
						$('.vacancy').addClass('colapsed');					
					};
					function rightpos(){
						var zzz=$(document).width();
						zzz=zzz-200-$(window).scrollLeft();
						$('#right-150').css('left',zzz+'px');
					}
					
					
					$(document).ready(function(){
						$('.vacancy-top').click(function(){
								if ($(this).parent('.vacancy').hasClass('colapsed'))
								{
									$('.vacancy').addClass('colapsed');
									$(this).parent('.vacancy').removeClass('colapsed');
					
					
								} else {
									$('.vacancy').addClass('colapsed');
								}
						});
						$('.vacancy-img').click(function(){
							var zzz=$(this).attr('data-id');
							var zzz1=$('#'+zzz+':hidden');
							$('.vacancy-toptext').slideUp(500);
							
					
							if (zzz1.length==1) $('#'+zzz).slideDown(500);
					
						});
						$( window ).resize(function() {
							$('.vacancy').removeClass('colapsed');
							$('.vacancy-text').height('auto');
							vacancyresize();
							rightpos();
						});
						$( window ).scroll(function() {
							rightpos();
						});
						
						/*Определяем максимальную высоту текста*/
						vacancyresize();
						rightpos();
					});

					</script><style type=\"text/css\">
					
					.vacancy-img{width:33%;float:left;cursor:pointer;}
					.vacancy-toptext{display:none;width:100%;}
					.vacancy-toptext h2{background-color:#d7e7f7;color:#446fad;margin:3px;padding:3px;margin-top:10px;font:18px Arial regular;font-weight:bold;}
					.vacancy-toptext p{font:14px Arial regular;}
					.vacancy.colapsed .vacancy-text {display:none;}
					.vacancy {border:1px solid #d3d3d3;border-top:0;border-bottom:0;}
					.vacancy-text{padding:0 10px;}
					.vacancy-text p {padding-top: 5px;font-size:14px;}
					.vacancy-top{padding-top:6px;padding-left: 20px;height:20px;cursor:pointer;}
					
					.vacancy-top{background:#d7e7f7;}
					.vacancy.colapsed .vacancy-top{background:url(/src/img/vac-top-back.jpg);}
					.vacancy-top h2{padding:0px;margin: 0px;font-size:13px;font-weight:normal;font-family: Arial;color:#446fad;}
					.vacancy.colapsed .vacancy-top h2{color:black;}
					.vacancy {width:100%;}
					/*.vacancy * {width:100%;}*/
					#left-150-3 {width:100%}
					#right-150 {background:#446fad;padding:0;
						position: fixed;
						top: 147px;
						left: 1000px;}
					#right-150 h2{padding: 6px 0px;font: 16px/16px Arial;font-weight: bold;}
					#right-150 p{padding: 2px 0px;font: 14px/16px Arial;text-align: center;}
					#right-150 * {color:white;}
					
					.table_cell_s {
						background-color: #D5D3D3;
						}
					</style>
					
					";
					
$addtxt.='
	<h3>Служба доставки Boxberry</h3>
	<p>Служба доставки Boxberry имеет широкую сеть собственных пунктов выдачи заказов в регионах России, более 100 пунктов.</p>
	<p>Ваш заказ может быть доставлен до пункта выдачи в Вашем городе на условиях 100%-ной предоплаты.</p>
	<p>Проверьте наличие пункта выдачи заказов в Вашем городе в следующем списке, а также узнайте его адрес, телефоны, режим работы и сроки доставки.</p>
	<p>Пункты выдачи заказов Boxberry:</p> 
	<div style="height:500px; overflow-x: hidden; overflow-y: scroll;">
	';
	
$nowscity='';
foreach($rows as $s)
{
	if ($nowscity!=$s['city']){
	if ($nowscity!='') $addtxt.="</table></p><br /></div></div>";
	$addtxt.='<div class="vacancy colapsed"><div class="vacancy-top"><h2>'.$s['city'].'</h2></div>';
	$addtxt.='<div class="vacancy-text"><p>
						<table width="100%" cellspacing="2" cellpadding="5">
	<tr>
		<td class="table_cell table_cell_s">КОД</td>
		<td class="table_cell table_cell_s">Адрес, контакты, зона и срок доставки</td>
		<td class="table_cell table_cell_s">Описание проезда</td>
	</tr>';
	$nowscity=$s['city'];
						
	}
	
$addtxt.='
	<tr>
		<td class="table_cell">'.$s['code'].'</td>
		<td width="48%" class="table_cell" style="text-align: left;"><b>Адрес:</b> '.$s['address'].'<br /><b>Телефон:</b> '.$s['phone'].'<br /><b>График работы:</b> '.$s['timework'].'<br /><b>Зона доставки:</b> '.$s['zone'].'<br /><b>Срок доставки:</b> '.$s['period'].' сут.</td>
		<!--<td class="table_cell">'.$s['zone'].'</td>
		<td class="table_cell">'.$s['period'].'</td>-->
		<td width="48%"class="table_cell">'.$s['description'].'</td>
	</tr>';
}
$addtxt.="</table></p><br /></div></div></div>";

$addtxt.='
<p>Узнать местонахождение своего заказа после его отправки Вы можете на сайте Boxberry.</p>
<p>После поступления заказ в пункт выдачи заказов Вашего города, Вам будет отправленно смс оповещения о готовности к выдаче Вашего заказа. В течении 2-х недель его можно будет забрать.</p>
<p>Получение посылки в пункте выдачи происходит максимально быстро, без очередей и заполнения лишних бумаг.</p>
<p>Стоимость доставки зависит от веса товарного вложения, а также от региона доставки:</p>		

<table width="100%" cellspacing="2" cellpadding="5">
	<tr>
		<td class="table_cell table_cell_s">Вес/Зона</td>
		<td class="table_cell table_cell_s">0</td>
		<td class="table_cell table_cell_s">1</td>
		<td class="table_cell table_cell_s">2</td>
		<td class="table_cell table_cell_s">3</td>
		<td class="table_cell table_cell_s">4</td>
	</tr>
	<tr>
		<td class="table_cell table_cell_s">Тариф</td>
		<td class="table_cell table_cell_s">Местный</td>
		<td class="table_cell table_cell_s">Региональный /Федеральный</td>
		<td class="table_cell table_cell_s">Федеральный</td>
		<td class="table_cell table_cell_s">Федеральный</td>
		<td class="table_cell table_cell_s">Федеральный</td>
	</tr>
	<tr>
		<td class="table_cell table_cell_s">Ед.изм.</td>
		<td class="table_cell table_cell_s">руб.</td>
		<td class="table_cell table_cell_s">руб.</td>
		<td class="table_cell table_cell_s">руб.</td>
		<td class="table_cell table_cell_s">руб.</td>
		<td class="table_cell table_cell_s">руб.</td>
	</tr>
	<tr>
		<td class="table_cell table_cell_s">Шаг</td>
		<td class="table_cell table_cell_s">2,00</td>
		<td class="table_cell table_cell_s">25,00</td>
		<td class="table_cell table_cell_s">28,00</td>
		<td class="table_cell table_cell_s">31,00</td>
		<td class="table_cell table_cell_s">34,00</td>
	</tr>
	<tr>
		<td class="table_cell">до 0.5 кг включительно</td>
		<td class="table_cell">49</td>
		<td class="table_cell">79</td>
		<td class="table_cell">89</td>
		<td class="table_cell">99</td>
		<td class="table_cell">109</td>
	</tr>
	
	<tr>
		<td class="table_cell">от 0.5 до 1.0 кг включительно</td>
		<td class="table_cell">51</td>
		<td class="table_cell">104</td>
		<td class="table_cell">117</td>
		<td class="table_cell">130</td>
		<td class="table_cell">143</td>
	</tr>
	
	<tr>
		<td class="table_cell">от 1.0 до 1.5 кг включительно</td>
		<td class="table_cell">53</td>
		<td class="table_cell">129</td>
		<td class="table_cell">145</td>
		<td class="table_cell">161</td>
		<td class="table_cell">177</td>
	</tr>
	
	<tr>
		<td class="table_cell">от 1.5 до 2.0 кг включительно</td>
		<td class="table_cell">55</td>
		<td class="table_cell">154</td>
		<td class="table_cell">173</td>
		<td class="table_cell">192</td>
		<td class="table_cell">211</td>
	</tr>
	<tr>
		<td class="table_cell">от 2.0 до 2.5 кг включительно</td>
		<td class="table_cell">57</td>
		<td class="table_cell">179</td>
		<td class="table_cell">201</td>
		<td class="table_cell">223</td>
		<td class="table_cell">245</td>
	</tr>
	<tr>
		<td class="table_cell">от 2.5 до 3.0 кг включительно</td>
		<td class="table_cell">59</td>
		<td class="table_cell">204</td>
		<td class="table_cell">229</td>
		<td class="table_cell">254</td>
		<td class="table_cell">279</td>
	</tr>
	<tr>
		<td class="table_cell">от 3.0 до 3.5 кг включительно</td>
		<td class="table_cell">61</td>
		<td class="table_cell">229</td>
		<td class="table_cell">257</td>
		<td class="table_cell">285</td>
		<td class="table_cell">313</td>
	</tr>
	<tr>
		<td class="table_cell">от 3.5 до 4.0 кг включительно</td>
		<td class="table_cell">63</td>
		<td class="table_cell">254</td>
		<td class="table_cell">285</td>
		<td class="table_cell">316</td>
		<td class="table_cell">347</td>
	</tr>
	<tr>
		<td class="table_cell">от 4.0 до 4.5 кг включительно</td>
		<td class="table_cell">65</td>
		<td class="table_cell">279</td>
		<td class="table_cell">313</td>
		<td class="table_cell">347</td>
		<td class="table_cell">381</td>
	</tr>
	<tr>
		<td class="table_cell">от 4.5 до 5.0 кг включительно</td>
		<td class="table_cell">67</td>
		<td class="table_cell">304</td>
		<td class="table_cell">341</td>
		<td class="table_cell">378</td>
		<td class="table_cell">415</td>
	</tr>
	<tr>
		<td class="table_cell">от 5.0 до 6.0 кг включительно</td>
		<td class="table_cell">70</td>
		<td class="table_cell">349</td>
		<td class="table_cell">391</td>
		<td class="table_cell">433</td>
		<td class="table_cell">475</td>
	</tr>
	<tr>
		<td class="table_cell">от 6.0 до 7.0 кг включительно</td>
		<td class="table_cell">73</td>
		<td class="table_cell">394</td>
		<td class="table_cell">441</td>
		<td class="table_cell">488</td>
		<td class="table_cell">535</td>
	</tr>
	<tr>
		<td class="table_cell">от 7.0 до 8.0 кг включительно</td>
		<td class="table_cell">76</td>
		<td class="table_cell">439</td>
		<td class="table_cell">491</td>
		<td class="table_cell">543</td>
		<td class="table_cell">595</td>
	</tr>
	<tr>
		<td class="table_cell">от 8.0 до 9.0 кг включительно</td>
		<td class="table_cell">79</td>
		<td class="table_cell">484</td>
		<td class="table_cell">541</td>
		<td class="table_cell">598</td>
		<td class="table_cell">655</td>
	</tr>
	<tr>
		<td class="table_cell">от 9.0 до 10.0 кг включительно</td>
		<td class="table_cell">82</td>
		<td class="table_cell">529</td>
		<td class="table_cell">591</td>
		<td class="table_cell">653</td>
		<td class="table_cell">715</td>
	</tr>
	<tr>
		<td class="table_cell">от 10.0 до 11.0 кг включительно</td>
		<td class="table_cell">85</td>
		<td class="table_cell">574</td>
		<td class="table_cell">641</td>
		<td class="table_cell">708</td>
		<td class="table_cell">775</td>
	</tr>
	<tr>
		<td class="table_cell">от 11.0 до 12.0 кг включительно</td>
		<td class="table_cell">88</td>
		<td class="table_cell">619</td>
		<td class="table_cell">691</td>
		<td class="table_cell">763</td>
		<td class="table_cell">835</td>
	</tr>
	<tr>
		<td class="table_cell">от 12.0 до 13.0 кг включительно</td>
		<td class="table_cell">91</td>
		<td class="table_cell">664</td>
		<td class="table_cell">741</td>
		<td class="table_cell">818</td>
		<td class="table_cell">895</td>
	</tr>
	<tr>
		<td class="table_cell">от 13.0 до 14.0 кг включительно</td>
		<td class="table_cell">94</td>
		<td class="table_cell">709</td>
		<td class="table_cell">791</td>
		<td class="table_cell">873</td>
		<td class="table_cell">955</td>
	</tr>
	<tr>
		<td class="table_cell">от 14.0 до 15.0 кг включительно</td>
		<td class="table_cell">97</td>
		<td class="table_cell">754</td>
		<td class="table_cell">841</td>
		<td class="table_cell">928</td>
		<td class="table_cell">1015</td>
	</tr>
	<tr>
		<td class="table_cell table_cell_s">Средняя</td>
		<td class="table_cell table_cell_s">70,75</td>
		<td class="table_cell table_cell_s">371,5</td>
		<td class="table_cell table_cell_s">415,5</td>
		<td class="table_cell table_cell_s">459,5</td>
		<td class="table_cell table_cell_s">503,5</td>
	</tr>
</table>
<br />

<p><b>Пример расчёта доставки до пункта выдачи Boxberry для 1 тарифной зоны:</b></p><p></p>
<div style="background-color:#F0F0F0;padding:15px;">
<p style="font-family:Courier New, Courier, monospace;font-size:11px;">Стоимость заказа - 2000 рублей, вес заказа - 1800 грамм<br />
Адрес отправки: г. Брянск - 1 тарифная зона<br />
Стоимость доставки в 1 тарифную зону до 2000 грамм(1800гр. вес товара +200гр. упаковка товара) – 154 руб.<br /><br />
Схема расчёта полной стоимости заказа: товар + тариф отправления по весу и дальности расположения региона + 105 рублей (оплата услуг транспортной компании).<br /><br />
Итого расходы по заказу составят: 2000 руб. + 154 руб.+105 руб. = 2259 руб.</p></div>

<p><b>Пример расчёта доставки до пункта выдачи Boxberry для 4 тарифной зоны:</b></p><p></p>
<div style="background-color:#F0F0F0;padding:15px;">
<p style="font-family:Courier New, Courier, monospace;font-size:11px;">Стоимость заказа - 2000 рублей, вес заказа - 1800 грамм<br />
Адрес отправки: г. Благовещенск - 4 тарифная зона<br />
Стоимость доставки в 4 тарифную зону до 2000 грамм(1800гр. вес товара +200гр. упаковка товара) – 211 руб.<br /><br />
Схема расчёта полной стоимости заказа: товар + тариф отправления по весу и дальности расположения региона + 105 рублей (оплата услуг транспортной компании).<br /><br />
Итого расходы по заказу составят: 2000 руб. + 211 руб.+105 руб. = 2316 руб.</p></div>
</div>';

echo $addtxt;
 ?>
<?php endif; ?>
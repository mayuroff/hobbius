
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
					.vacancy.colapsed .vacancy-top{background:url(/img/vac-top-back.jpg);}
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
	<h3>Курьерская служба доставки Boxberry</h3>
	<p>Служба доставки Boxberry , так же осущестляет Курьерскую доставку по городам РФ.</p>
	<p>Список городов в которых осуществляется курьерская доставка:</p>
	<div style="height:500px; overflow-x: hidden; overflow-y: scroll;">
	';
	
$addtxt.='
<table width="100%" cellspacing="2" cellpadding="5">
	<tr>
		<td class="table_cell table_cell_s">Город</td>
		<td class="table_cell table_cell_s">Тарифная зона</td>
		<td class="table_cell table_cell_s">Сроки, сут.</td>
	</tr>';
	
foreach($rows as $s)
{	
	$s['period']++;				
	$addtxt.='
		<tr>
			<td class="table_cell">'.$s['city'].'</td>
			<td width="48%" class="table_cell">'.$s['zone'].'</td>
			<td class="table_cell">'.$s['period'].'</td>
		</tr>';
}
$addtxt.="</table></div>";

$addtxt.='
	<br />
<p>Узнать местонахождение своего заказа после его отправки Вы можете на сайте Boxberry.</p>
<p>После поступления заказа в пункт Boxberry  Вашего города, с Вами свяжется служба доставки и уточнит дату,и время доставки Вашего заказа.</p>
<p>Стоимость доставки зависит от веса товарного вложения, а также от региона доставки:</p>		

<table width="100%" cellspacing="2" cellpadding="5">
	<tr>
		<td class="table_cell table_cell_s">Вес/Зона</td>
		<td class="table_cell table_cell_s">1</td>
		<td class="table_cell table_cell_s">2</td>
		<td class="table_cell table_cell_s">3</td>
		<td class="table_cell table_cell_s">4</td>
	</tr>
	<tr>
		<td class="table_cell table_cell_s">Тариф</td>
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
	</tr>
	<tr>
		<td class="table_cell table_cell_s">Шаг</td>
		<td class="table_cell table_cell_s">34,00</td>
		<td class="table_cell table_cell_s">37,00</td>
		<td class="table_cell table_cell_s">40,00</td>
		<td class="table_cell table_cell_s">43,00</td>
	</tr>
	<tr>
		<td class="table_cell">до 0.5 кг включительно</td>
		<td class="table_cell">228</td>
		<td class="table_cell">238</td>
		<td class="table_cell">248</td>
		<td class="table_cell">258</td>
	</tr>
	
	<tr>
		<td class="table_cell">от 0.5 до 1.0 кг включительно</td>
		<td class="table_cell">262</td>
		<td class="table_cell">275</td>
		<td class="table_cell">288</td>
		<td class="table_cell">301</td>
	</tr>
	
	<tr>
		<td class="table_cell">от 1.0 до 1.5 кг включительно</td>
		<td class="table_cell">296</td>
		<td class="table_cell">312</td>
		<td class="table_cell">328</td>
		<td class="table_cell">344</td>
	</tr>
	
	<tr>
		<td class="table_cell">от 1.5 до 2.0 кг включительно</td>
		<td class="table_cell">330</td>
		<td class="table_cell">349</td>
		<td class="table_cell">368</td>
		<td class="table_cell">387</td>
	</tr>
	<tr>
		<td class="table_cell">от 2.0 до 2.5 кг включительно</td>
		<td class="table_cell">364</td>
		<td class="table_cell">386</td>
		<td class="table_cell">408</td>
		<td class="table_cell">430</td>
	</tr>
	<tr>
		<td class="table_cell">от 2.5 до 3.0 кг включительно</td>
		<td class="table_cell">398</td>
		<td class="table_cell">423</td>
		<td class="table_cell">448</td>
		<td class="table_cell">473</td>
	</tr>
	<tr>
		<td class="table_cell">от 3.0 до 3.5 кг включительно</td>
		<td class="table_cell">432</td>
		<td class="table_cell">460</td>
		<td class="table_cell">488</td>
		<td class="table_cell">516</td>
	</tr>
	<tr>
		<td class="table_cell">от 3.5 до 4.0 кг включительно</td>
		<td class="table_cell">466</td>
		<td class="table_cell">497</td>
		<td class="table_cell">528</td>
		<td class="table_cell">559</td>
	</tr>
	<tr>
		<td class="table_cell">от 4.0 до 4.5 кг включительно</td>
		<td class="table_cell">500</td>
		<td class="table_cell">534</td>
		<td class="table_cell">568</td>
		<td class="table_cell">602</td>
	</tr>
	<tr>
		<td class="table_cell">от 4.5 до 5.0 кг включительно</td>
		<td class="table_cell">534</td>
		<td class="table_cell">571</td>
		<td class="table_cell">608</td>
		<td class="table_cell">645</td>
	</tr>
	<tr>
		<td class="table_cell">от 5.0 до 6.0 кг включительно</td>
		<td class="table_cell">595</td>
		<td class="table_cell">637</td>
		<td class="table_cell">679</td>
		<td class="table_cell">721</td>
	</tr>
	<tr>
		<td class="table_cell">от 6.0 до 7.0 кг включительно</td>
		<td class="table_cell">656</td>
		<td class="table_cell">703</td>
		<td class="table_cell">750</td>
		<td class="table_cell">797</td>
	</tr>
	<tr>
		<td class="table_cell">от 7.0 до 8.0 кг включительно</td>
		<td class="table_cell">717</td>
		<td class="table_cell">769</td>
		<td class="table_cell">821</td>
		<td class="table_cell">873</td>
	</tr>
	<tr>
		<td class="table_cell">от 8.0 до 9.0 кг включительно</td>
		<td class="table_cell">778</td>
		<td class="table_cell">835</td>
		<td class="table_cell">892</td>
		<td class="table_cell">949</td>
	</tr>
	<tr>
		<td class="table_cell">от 9.0 до 10.0 кг включительно</td>
		<td class="table_cell">839</td>
		<td class="table_cell">901</td>
		<td class="table_cell">963</td>
		<td class="table_cell">1025</td>
	</tr>
	<tr>
		<td class="table_cell">от 10.0 до 11.0 кг включительно</td>
		<td class="table_cell">900</td>
		<td class="table_cell">967</td>
		<td class="table_cell">1034</td>
		<td class="table_cell">1101</td>
	</tr>
	<tr>
		<td class="table_cell">от 11.0 до 12.0 кг включительно</td>
		<td class="table_cell">961</td>
		<td class="table_cell">1033</td>
		<td class="table_cell">1105</td>
		<td class="table_cell">1177</td>
	</tr>
	<tr>
		<td class="table_cell">от 12.0 до 13.0 кг включительно</td>
		<td class="table_cell">1022</td>
		<td class="table_cell">1099</td>
		<td class="table_cell">1176</td>
		<td class="table_cell">1253</td>
	</tr>
	<tr>
		<td class="table_cell">от 13.0 до 14.0 кг включительно</td>
		<td class="table_cell">1083</td>
		<td class="table_cell">1165</td>
		<td class="table_cell">1247</td>
		<td class="table_cell">1329</td>
	</tr>
	<tr>
		<td class="table_cell">от 14.0 до 15.0 кг включительно</td>
		<td class="table_cell">1144</td>
		<td class="table_cell">1231</td>
		<td class="table_cell">1318</td>
		<td class="table_cell">1405</td>
	</tr>
	<tr>
		<td class="table_cell table_cell_s">Средняя</td>
		<td class="table_cell table_cell_s">625,25</td>
		<td class="table_cell table_cell_s">669,25</td>
		<td class="table_cell table_cell_s">713,25</td>
		<td class="table_cell table_cell_s">757,25</td>
	</tr>
</table>
<br />

<p><b>Пример расчёта курьерской доставки для 1 тарифной зоны:</b></p><p></p>
<div style="background-color:#F0F0F0;padding:15px;">
<p style="font-family:Courier New, Courier, monospace;font-size:11px;">Стоимость заказа - 2000 рублей, вес заказа - 1800 грамм<br />
Адрес отправки: г. Брянск - 1 тарифная зона<br />
Стоимость доставки в 1 тарифную зону до 2000 грамм(1800гр. вес товара +200гр. упаковка товара) – 330 руб.<br /><br />
Схема расчёта полной стоимости заказа: товар + тариф отправления по весу и дальности расположения региона + 105 рублей (оплата услуг транспортной компании).<br /><br />
Итого расходы по заказу составят: 2000 руб. + 330 руб.+105 руб. = 2435 руб.</p></div>

<p><b>Пример расчёта курьерской доставки для 4 тарифной зоны:</b></p><p></p>
<div style="background-color:#F0F0F0;padding:15px;">
<p style="font-family:Courier New, Courier, monospace;font-size:11px;">Стоимость заказа - 2000 рублей, вес заказа - 1800 грамм<br />
Адрес отправки: г. Благовещенск - 4 тарифная зона<br />
Стоимость доставки в 4 тарифную зону до 2000 грамм(1800гр. вес товара +200гр. упаковка товара) – 387 руб.<br /><br />
Схема расчёта полной стоимости заказа: товар + тариф отправления по весу и дальности расположения региона + 105 рублей (оплата услуг транспортной компании).<br /><br />
Итого расходы по заказу составят: 2000 руб. + 387 руб.+105 руб. = 2492 руб.</p></div>
</div>';

echo $addtxt;
 ?>
<?php endif; ?>
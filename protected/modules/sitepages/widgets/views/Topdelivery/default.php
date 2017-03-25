
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
	<h3>Служба доставки TopDelivery</h3>
	<p>Служба доставки TopDelivery имеет широкую сеть собственных пунктов выдачи заказов в регионах России.</p>
	<p>Ваш заказ может быть доставлен до пункта выдачи в Вашем городе на условиях 100%-ной предоплаты.</p>
	<p>Проверьте наличие пункта выдачи заказов в Вашем городе в следующем списке, а также узнайте его адрес и сроки доставки.</p>
	<p>Пункты выдачи заказов TopDelivery:</p> 
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
		<td class="table_cell table_cell_s">Адрес</td>
		<td class="table_cell table_cell_s">Срок доставки*</td>
	</tr>';
	$nowscity=$s['city'];
						
	}
	
$addtxt.='
	<tr>
		<td width="48%" class="table_cell" style="text-align: left;"><b>'.$s['address'].'</b></td>
		<td width="48%"class="table_cell">'.$s['period'].'</td>
	</tr>';
}
$addtxt.="</table></p><br /></div></div></div>";

$addtxt.='<br /><div>*Срок доставки указан до пункта выдачи. Доставка до клиента +1 день или по согласованию с клиентом</div>
</div>';

echo $addtxt;
 ?>
<?php endif; ?>
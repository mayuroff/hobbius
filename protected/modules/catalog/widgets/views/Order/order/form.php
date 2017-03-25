<?php 

	$form_order=new Form('order_form');
	$form_order->configure(array(
			"prevent" =>array("bootstrap","jQuery"),
			//"prevent" =>array("jQuery"),
			"action" =>""
	));
	

	$form_order->addElement(new Element_Hidden("form","order_form"));
	$form_order->addElement(new Element_HTML('<div style="max-width: 1200px; margin: 0 auto; padding: 10px 20px 0 20px;">'));
	$form_order->addElement(new Element_HTML('<div><b>Для оформления заказа Вам необходимо заполнить следующую форму.</b></div>'));
	$form_order->addElement(new Element_HTML('<div class="orderform contact">Контактные данные</div>'));
	$form_order->addElement(new Element_HTML('<div class="contacterror" style="display:none;">Необходимо заполнить все обязательные поля!</div>'));
	$form_order->addElement(new Element_HTML('<div class="basket-contact">'));
	$form_order->addElement(new Element_Textbox('Фамилия ','reg_surname',array( "required" => 1)));
	$form_order->addElement(new Element_Textbox('Имя ','reg_name',array( "required" => 1)));
	//$form_order->addElement(new Element_Textbox('Отчество','reg_name2'));
	$form_order->addElement(new Element_Textbox('Телефон ','reg_phone',array( "required" => 1)));
	//$form_order->addElement(new Element_Textbox('Доп. телефон','reg_phone2'));
	$form_order->addElement(new Element_Email('E-mail ','reg_email',array( "required" => 1)));
	$form_order->addElement(new Element_HTML('</div>'));
	$form_order->addElement(new Element_HTML('<div class="basket-contact">'));
	$form_order->addElement(new Element_Textbox('Почтовый индекс','reg_postcode'));
	//$form_order->addElement(new Element_Textbox('Страна,город','reg_city'));
	$form_order->addElement(new Element_Select('Страна доставки','reg_country',$delivery_country,array( "required" => 1)));
	
$form_order->addElement(new Element_HTML('<div class="reg_country_input">'));
$form_order->addElement(new Element_Textbox('Введите страну','reg_country_text',array( "required" => 1)));
$form_order->addElement(new Element_HTML('</div>'));
	
	$form_order->addElement(new Element_Textbox('Город','reg_city',array( "required" => 1)));
	$form_order->addElement(new Element_Textbox('Адрес доставки ','reg_address',array( "required" => 1)));
	//$form_order->addElement(new Element_Textbox('№ дисконтной карты','reg_discont'));
	$form_order->addElement(new Element_Textarea('Комментарии','reg_comments'));
	$form_order->addElement(new Element_HTML('</div>'));
	
	$form_order->addElement(new Element_Hidden("id_city",""));
	$form_order->addElement(new Element_Hidden("box_type",""));
	$form_order->addElement(new Element_Hidden("box_kurer",""));
	
	$form_order->addElement(new Element_HTML('<div class="orderform delivery">Способ доставки</div>'));
	
	$form_order->addElement(new Element_Radio("","type_arrive",$delivery_options,Array("class"=>"delivery_select","required" => 1)));

	/*if ($nonal==1){//Запрет наложенного платежа
		$form_order->addElement(new Element_HTML('<div class="control-group"><div class="controls delivery_select">Товары, обозначенные в корзине <div style="color:#8c691e;font-weight:bold;display:inline;">горчичным цветом</div> наложенным платежом не доставляются</div></div>'));
	}*/	

	$form_order->addElement(new Element_HTML('<div class="orderform pay">Способ оплаты</div>'));
	$form_order->addElement(new Element_Radio("","type_pay",$pay_options,Array("class"=>"pay_select","required" => 1)));
	
	//$form_order->addElement(new Element_HTML('<div class="catalog-line"></div>'));
	//$nal_options[1]='Отправить только полностью набранный заказ';
	//$nal_options[2]='Отправить имеющуюся в наличии часть заказа, но не менее половины';
	//$form_order->addElement(new Element_Radio("Наличие","reg_nalichie",$nal_options));
	//$form_order->addElement(new Element_HTML('<div class="catalog-line"></div>'));
	//$form_order->addElement(new Element_Checkbox('','reg_nalichie2',Array(1 => 'Сообщить об отсутствующих позициях')));
	
	//$form_order->addElement(new Element_HTML('<div class="catalog-line"></div>'));
	

	//$primechanie_options[2]='в личных целях';
	//$primechanie_options[1]='в коммерческих целях';
	//$form_order->addElement(new Element_Select("Назначение","reg_ordtype",$primechanie_options));
	//$form_order->addElement(new Element_Button('Назад в корзину','',Array("class"=>"btn-xs btn-danger","onclick"=>"window.location='/cart/';return false;")));
	$form_order->addElement(new Element_Button('Оформить заказ','',Array("class"=>"btn-success")));
	$form_order->addElement(new Element_HTML('</div>'));
	

	?>
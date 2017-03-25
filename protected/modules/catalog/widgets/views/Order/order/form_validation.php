<?php 
$valid=false;
Form::clearErrors('order_form');

if ($ORDER_DATA['reg_country'] == 1) {
	//Доставка курьером по Москве действует только по Москве
	if ($ORDER_DATA['type_arrive']==3 && $ORDER_DATA['reg_city']!='Москва')
	{
		$ORDER_DATA['type_arrive']=0;
	}
	//Самовывоз действует только по Москве
	if ($ORDER_DATA['type_arrive']==6 && $ORDER_DATA['reg_city']!='Москва')
	{
		$ORDER_DATA['type_arrive']=0;
	}
	//Самовывоз действует только по Москве
	/*if ($ORDER_DATA['type_arrive']==5 && $ORDER_DATA['reg_city']!='Москва')
	{
		$ORDER_DATA['type_arrive']=0;
	}*/
	//Доставка курьером по Екатеринбургу действует только по Екатеринбургу
	/*if ($ORDER_DATA['type_arrive']==4 &&  $ORDER_DATA['reg_city']!='Екатеринбург')
	{
		$ORDER_DATA['type_arrive']=0;
	}*/
	//Доставка Почтой России недоступна по Москве
	if ($ORDER_DATA['type_arrive']==2 &&  $ORDER_DATA['reg_city']=='Москва')
	{
		$ORDER_DATA['type_arrive']=0;
	}
	//Доставка курьером Boxberry по РФ недоступна по Москве
	if ($ORDER_DATA['type_arrive']==4 &&  $ORDER_DATA['reg_city']=='Москва')
	{
		$ORDER_DATA['type_arrive']=0;
	}
	//Тип оплаты "Наложенный платеж" доступен только для отправки почтой россии
	if ($ORDER_DATA['type_arrive']!=2 && ($ORDER_DATA['type_pay']==1))
	{
		$ORDER_DATA['type_pay']=0;
	}
	//Оплата "наличными" недоступна для почты россии, аналог - "наложенный платеж"
	if ($ORDER_DATA['type_arrive']==2 && ($ORDER_DATA['type_pay']==3))
	{
		$ORDER_DATA['type_pay']=0;
	}
	
	
	//Пункты выдачи Boxberry по РФ при 100 %
	if ($ORDER_DATA['type_arrive']==5)
	{
		if ( ($ORDER_DATA['type_pay']!=2) && ($ORDER_DATA['type_pay']!=4) )
			$ORDER_DATA['type_pay']=0;
	}
	
	
	if ($ORDER_DATA['type_arrive']>=1000)
	{
		$sql = 'SELECT iddeliv FROM leo_delivery WHERE iddeliv='.$ORDER_DATA['type_arrive'];
		$command=Yii::app()->db->createCommand($sql);
		$s1=$command->query();
		if (sizeof($s1) == 0)
		{
			//Если спецдоставка не найдена - убираем тип доставки
			$ORDER_DATA['type_arrive']=0;
		}
	}
	
}
elseif ($ORDER_DATA['reg_country'] == 2) {
	
if ($ORDER_DATA['reg_country_text']==NULL)Form::setError('order_form','Введите страну доставки','reg_country_text');
	
	if ($ORDER_DATA['type_arrive']!=2)
	{
		$ORDER_DATA['type_arrive']=0;
	}
	elseif ( ($ORDER_DATA['type_pay']!=2) && ($ORDER_DATA['type_pay']!=4) ) {
		$ORDER_DATA['type_pay']=0;
	}
}

if ($ORDER_DATA['reg_phone']==NULL)Form::setError('order_form','Введите контактный телефон','reg_phone');
if ($ORDER_DATA['reg_surname']==NULL)Form::setError('order_form','Введите фамилию','reg_surname');
if ($ORDER_DATA['reg_name']==NULL)Form::setError('order_form','Введите имя','reg_name');
if ($ORDER_DATA['reg_email']==NULL)Form::setError('order_form','Введите адрес электронной почты','reg_email');
//elseif (!preg_match("/^[0-9A-z][-A-z0-9_]+([.][-A-z0-9_]+)*[@][-A-z0-9_]+([.][-A-z0-9_-]+)*[.][A-z]{2,8}$/",$ORDER_DATA['reg_email']))Form::setError('order_form','Проверьте правильность написания электонной почты','reg_email');
//if ($ORDER_DATA['reg_country']==3)Form::setError('order_form','Выберите страну доставки','reg_country');
if ($ORDER_DATA['reg_address']==NULL)Form::setError('order_form','Введите город доставки','reg_address');

if ($ORDER_DATA['type_arrive']==3 && $ORDER_DATA['reg_city']!='Москва')
{
	Form::setError('order_form','Доставка курьером осуществляется только в Москву, введите другой Город доставки или выберите другой способ доставки','reg_city');
}
if ($ORDER_DATA['type_arrive']==0){
	Form::setError('order_form','Выберите способ доставки','type_arrive');
}
if ($ORDER_DATA['type_pay']==0){
	Form::setError('order_form','Выберите способ оплаты','type_pay');
}	

 $valid=Form::isStaticValid('order_form');
?>
<?php 
if (!isset($ORDER_DATA))return;
if (!isset($ORDER_DATA['type_arrive']))$ORDER_DATA['type_arrive']=0;
if (!is_numeric($ORDER_DATA['type_arrive']))$ORDER_DATA['type_arrive']=0;
if (!isset($ORDER_DATA['type_pay']))$ORDER_DATA['type_pay']=0;
if (!is_numeric($ORDER_DATA['type_pay']))$ORDER_DATA['type_pay']=0;
if (!isset($ORDER_DATA['reg_surname']))$ORDER_DATA['reg_surname']='';
if (!isset($ORDER_DATA['reg_name']))$ORDER_DATA['reg_name']='';
if (!isset($ORDER_DATA['reg_name2']))$ORDER_DATA['reg_name2']='';
if (!isset($ORDER_DATA['reg_phone']))$ORDER_DATA['reg_phone']='';
if (!isset($ORDER_DATA['box_type']))$ORDER_DATA['box_type']='';
if (!isset($ORDER_DATA['reg_email']))$ORDER_DATA['reg_email']='';
if (!isset($ORDER_DATA['reg_postcode']))$ORDER_DATA['reg_postcode']='';
if (!isset($ORDER_DATA['reg_country']))$ORDER_DATA['reg_country']='';

if (!isset($ORDER_DATA['reg_country_text']))$ORDER_DATA['reg_country_text']='';

if (!isset($ORDER_DATA['reg_city']))$ORDER_DATA['reg_city']='';
if (!isset($ORDER_DATA['reg_address']))$ORDER_DATA['reg_address']='';
if (!isset($ORDER_DATA['reg_discont']))$ORDER_DATA['reg_discont']='';
if (!isset($ORDER_DATA['reg_comments']))$ORDER_DATA['reg_comments']='';
if (!isset($ORDER_DATA['reg_nalichie']))$ORDER_DATA['reg_nalichie']=2;
if (!is_numeric($ORDER_DATA['reg_nalichie']))$ORDER_DATA['reg_nalichie']=2;
if (!isset($ORDER_DATA['reg_nalichie2']))$ORDER_DATA['reg_nalichie2']=1;
if (!is_numeric($ORDER_DATA['reg_nalichie2']))$ORDER_DATA['reg_nalichie2']=1;
if (!isset($ORDER_DATA['reg_ordtype']))$ORDER_DATA['reg_ordtype']=2;
if (!is_numeric($ORDER_DATA['reg_ordtype']))$ORDER_DATA['reg_ordtype']=2;
//Маленькую валидацию провели, теперь сохраняем.
/*$sql='UPDATE '.PREFIX.'_clients'.TYPE_ORDER.' SET type_arrive='.$ORDER_DATA['type_arrive'].',reg_surname=\''.$ORDER_DATA['reg_surname'].'\'
		,reg_name=\''.$ORDER_DATA['reg_name'].'\',reg_name2=\''.$ORDER_DATA['reg_name2'].'\',reg_phone=\''.$ORDER_DATA['reg_phone'].'\'
		,reg_phone2=\''.$ORDER_DATA['reg_phone2'].'\',reg_email=\''.$ORDER_DATA['reg_email'].'\'
		,reg_postcode=\''.$ORDER_DATA['reg_postcode'].'\',reg_country=\''.$ORDER_DATA['reg_country'].'\'
		,reg_city=\''.$ORDER_DATA['reg_city'].'\',reg_address=\''.$ORDER_DATA['reg_address'].'\'
		,reg_discont=\''.$ORDER_DATA['reg_discont'].'\',reg_comments=\''.$ORDER_DATA['reg_comments'].'\'
		,reg_nalichie='.$ORDER_DATA['reg_nalichie'].',reg_nalichie2='.$ORDER_DATA['reg_nalichie2'].'
		,reg_ordtype='.$ORDER_DATA['reg_ordtype'].',type_pay='.$ORDER_DATA['type_pay'].' WHERE client_id='.$userid;
$DB->Query($sql);*/



?>
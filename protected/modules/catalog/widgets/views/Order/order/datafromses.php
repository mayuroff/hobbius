<?php 
//Грабим из SESSION в $ORDER_DATA
if(isset($_SESSION['type_arrive'])) $ORDER_DATA['type_arrive']=txt2xml($_SESSION['type_arrive']); else $ORDER_DATA['type_arrive']=0;
if(isset($_SESSION['type_pay'])) $ORDER_DATA['type_pay']=txt2xml($_SESSION['type_pay']); else $ORDER_DATA['type_pay']=0;

if(isset($_SESSION["reg_surname"])) $ORDER_DATA["reg_surname"]=txt2xml($_SESSION["reg_surname"]); else $ORDER_DATA["reg_surname"]=NULL;
if(isset($_SESSION["reg_name"])) $ORDER_DATA["reg_name"]=txt2xml($_SESSION["reg_name"]); else $ORDER_DATA["reg_name"]=NULL;
//if(isset($_SESSION["reg_name2"])) $ORDER_DATA["reg_name2"]=txt2xml($_SESSION["reg_name2"]); else $ORDER_DATA["reg_name2"]=NULL;
if(isset($_SESSION["reg_email"])) $ORDER_DATA["reg_email"]=txt2xml($_SESSION["reg_email"]); else $ORDER_DATA["reg_email"]=NULL;
if(isset($_SESSION["reg_phone"])) $ORDER_DATA["reg_phone"]=txt2xml($_SESSION["reg_phone"]); else $ORDER_DATA["reg_phone"]=NULL;
if(isset($_SESSION["box_type"])) $ORDER_DATA["box_type"]=txt2xml($_SESSION["box_type"]); else $ORDER_DATA["box_type"]=NULL;
if(isset($_SESSION["reg_postcode"])) $ORDER_DATA["reg_postcode"]=txt2xml($_SESSION["reg_postcode"]); else $ORDER_DATA["reg_postcode"]=NULL;
if(isset($_SESSION["reg_country"])) $ORDER_DATA["reg_country"]=txt2xml($_SESSION["reg_country"]); else $ORDER_DATA["reg_country"]=NULL;

if(isset($_SESSION["reg_country_text"])) $ORDER_DATA["reg_country_text"]=txt2xml($_SESSION["reg_country_text"]); else $ORDER_DATA["reg_country_text"]=NULL;

if(isset($_SESSION["reg_city"])) $ORDER_DATA["reg_city"]=txt2xml($_SESSION["reg_city"]); else $ORDER_DATA["reg_city"]=NULL;
if(isset($_SESSION["reg_address"])) $ORDER_DATA["reg_address"]=txt2xml($_SESSION["reg_address"]); else $ORDER_DATA["reg_address"]=NULL;
if(isset($_SESSION["reg_comments"])) $ORDER_DATA["reg_comments"]=txt2xml($_SESSION["reg_comments"]); else $ORDER_DATA["reg_comments"]=NULL;
if(isset($_SESSION["reg_discont"])) $ORDER_DATA["reg_discont"]=txt2xml($_SESSION["reg_discont"]); else $ORDER_DATA["reg_discont"]=NULL;
/*if(isset($_SESSION["reg_nalichie"])) $ORDER_DATA["reg_nalichie"]=txt2xml($_SESSION["reg_nalichie"]); else */$ORDER_DATA["reg_nalichie"]=2;
/*if(isset($_SESSION["reg_nalichie2"])) $ORDER_DATA["reg_nalichie2"]=txt2xml($_SESSION["reg_nalichie2"]); else */$ORDER_DATA["reg_nalichie2"]=1;
/*if(isset($_SESSION["reg_ordtype"])) $ORDER_DATA["reg_ordtype"]=txt2xml($_SESSION["reg_ordtype"]); else */$ORDER_DATA["reg_ordtype"]=2;

//if(isset($_SESSION["reg_cel"])) $ORDER_DATA["reg_cel"]=$_SESSION["reg_cel"]; else $ORDER_DATA["reg_cel"]=0;
//if(isset($_SESSION["reg_money"])) $ORDER_DATA["reg_money"]=$_SESSION["reg_money"]; else $ORDER_DATA["reg_money"]=1;
//if(isset($_SESSION["reg_code"])) $ORDER_DATA["reg_code"]=$_SESSION["reg_code"]; else $ORDER_DATA["reg_code"]=NULL;
//if(isset($_SESSION["reg_code2"])) $ORDER_DATA["reg_code2"]=$_SESSION["reg_code2"]; else $ORDER_DATA["reg_code2"]=NULL;

?>
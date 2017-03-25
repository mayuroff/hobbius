function onAssort(prod,shop) 
{
	$('#firstcolomn_head').css('background-image', 'url(/img2/load_my.gif)');
	var id = prod+'-'+shop;
	$('#'+id).load('/assortment/backend/check', {'id':id, 'prod':prod, 'shop':shop});
}
<?php if(isset($rows) && ($rows != array())): ?>
	
	<?php 
	
	$forwhom1_text = 'checked="checked"';
	$forwhom2_text = 'checked="checked"';
	$know1 = 'checked="checked"';
	$know2 = "";
	$complex1_text = 'checked="checked"';
	$complex2_text = 'checked="checked"';
	$complex3_text = 'checked="checked"';
	
	$s1 = "500";
	$s2 = "5000";
	
	$sql = "select MIN(Price) from Goods where Price>0";
	$command=Yii::app()->db->createCommand($sql);
	$command=Yii::app()->db->createCommand($sql);
	$s1=$command->queryScalar();
	
	$sql = "select MAX(Price) from Goods";
	$command=Yii::app()->db->createCommand($sql);
	$s2=$command->queryScalar();
	
	$s1=$s1-10;
	$s2=$s2+10;
	
	$s2_max=$s2+500;
	
	if (isset($_SESSION['search_cat'])) $search = $_SESSION['search_cat']; else $search = ""; 
	if (isset($_SESSION['search_pr1'])) $pr1 = str_replace(" ", "", $_SESSION['search_pr1']); else $pr1 = $s1;
	if (isset($_SESSION['search_pr2'])) $pr2 = str_replace(" ", "", $_SESSION['search_pr2']); else $pr2 = $s2;
	if (isset($_SESSION['search_forwhom1'])) {
		$forwhom1 = $_SESSION['search_forwhom1'];
		if ($forwhom1 == 1) $forwhom1_text = 'checked="checked"';
		else $forwhom1_text = "";
	}
	else $forwhom1 = 0;
	if (isset($_SESSION['search_forwhom2'])) {
		$forwhom2 = $_SESSION['search_forwhom2']; 
		if ($forwhom2 == 1) $forwhom2_text = 'checked="checked"';
		else $forwhom2_text = "";
	}
	else $forwhom2 = 0;
	if (isset($_SESSION['search_theme'])) $theme = $_SESSION['search_theme']; else $theme = "";
	if (isset($_SESSION['search_know'])) {
		$know = $_SESSION['search_know'];
		if ($know == 1) $know1 = 'checked="checked"';
		elseif ($know == 2) $know2 = 'checked="checked"';
	} else $know = "";
	if (isset($_SESSION['search_complex1'])) {
		$complex1 = $_SESSION['search_complex1'];
		if ($complex1 == 1) $complex1_text = 'checked="checked"';
		else $complex1_text = "";
	} else $complex1 = "";
	if (isset($_SESSION['search_complex2'])) {
		$complex2 = $_SESSION['search_complex2'];
		if ($complex2 == 1) $complex2_text = 'checked="checked"';
		else $complex2_text = "";
	} else $complex2 = "";
	if (isset($_SESSION['search_complex3'])) {
		$complex3 = $_SESSION['search_complex3'];
		if ($complex3 == 1) $complex3_text = 'checked="checked"';
		else $complex3_text = "";
	} else $complex3 = "";
	
	echo "<script> var price_values = [ ".$pr1.", ".$pr2." ]; var price_max = ".$s2_max."; </script>";
	
	?>
	
	<div class="filter">
		<form action="/search/" method="post">
			<div class="filter-title">
				Фильтр товара
			</div>
			<div class="filter-block">
				<b>Артикул/Название</b>
			</div>
			<div class="filter-block">
				<input type="text" name="s" id="a" value="<?php echo $search; ?>" class="filter-article">
			</div>
			<div class="line"></div>
			<div class="filter-block">
				<b>Диапазон цен</b> руб.
			</div>
			<div class="filter-block">
				<input type="text" name="pr1" value="<?php echo $pr1; ?>" class="filter-price" id="price">
				до
				<input type="text" name="pr2" value="<?php echo $pr2; ?>" class="filter-price" id="price2">
			</div>
			<div class="filter-block">
				<div id="slider_price"></div>
			</div>
			<!--<div class="line"></div>
			<div class="filter-block">
				<b>Для кого?</b>
			</div>
			<div class="filter-block">
				<div class = "box-radio">
					<input type="checkbox" id="m001" value="1" name="forwhom1" <?php echo $forwhom1_text; ?> class="regular-checkbox"><label for="m001" title="для дам"></label>
					<p>для дам</p>
				</div>
				<div class = "box-radio">
					<input type="checkbox" id="m002" value="1" name="forwhom2" <?php echo $forwhom2_text; ?> class="regular-checkbox"><label for="m002" title="для мужчин"></label>
					<p>для мужчин</p>
				</div>
			</div>
			<div class="line"></div>
			<div class="filter-block">
				<b>Выберите тему</b>
			</div>
			<div class="filter-block">
				<select name="theme">
					<option value="0">любая</option>
					<option value="1" selected="selected">любая любая любая любая любая любая</option>
				</select>
			</div>-->
			<div class="line"></div>
			<div class="filter-block">
				<b>Наполнитель в наборе</b>
			</div>
			<div class="filter-block">
				<div class = "box-radio">
					<input type="radio" id="r001" value="1" name="know" <?php echo $know1; ?> class="regular-radio" /><label for="r001" title=""></label>
					<p>Есть</p>
				</div>
				<div class = "box-radio">
					<input type="radio" id="r002" value="2" name="know" <?php echo $know2; ?> class="regular-radio" /><label for="r002" title=""></label>
					<p>Нет</p>
				</div>
			</div>
			<!-- <div class="line"></div>
			<div class="filter-block">
				<b>Сложность</b>
			</div>
			<div class="filter-block">
				<div class = "box-radio">
					<input type="checkbox" id="m003" value="1" name="complex1" <?php echo $complex1_text;?> class="regular-checkbox"><label for="m003" title="Легко"></label>
					<p>Легко</p>
				</div>
				<div class = "box-radio">			
					<input type="checkbox" id="m004" value="1" name="complex2" <?php echo $complex2_text;?> class="regular-checkbox"><label for="m004" title="Средне"></label>
					<p>Средне</p>
				</div>
				<div class = "box-radio">
					<input type="checkbox" id="m005" value="1" name="complex3" <?php echo $complex3_text;?> class="regular-checkbox"><label for="m005" title="Тяжело"></label>
					<p>Тяжело</p>
				</div>
			</div>-->
			<div class="filter-block" style="height:30px">
				<input type="submit" class="filter-sub" value="">
			</div>
		</form>
	</div>
			
	
<?php endif; ?>


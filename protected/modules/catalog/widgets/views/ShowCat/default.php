<?php if(isset($rows) && ($rows != array())): ?>
	<div class="catalog">
		<a href="/catalog/" style="text-decoration: none;">
			<div class="cat-title">
				Каталог
			</div>
		</a>
		<ul class="cat-ul">
			
		<?php $i = 0; $firstelem = ""; $nextelem = ""; foreach ($rows as $row): ?>

			<?php
			
			if ($row['PosID'] == 23675941562) $firstelem = '<li><a href="/catalog/'.$row['PosID'].'/"><div>'.$row['PosName'].'</div></a></li>';
			else $nextelem .= '<li class="cat-elem"><a href="/catalog/'.$row['PosID'].'/"><div>'.$row['PosName'].'</div></a></li>';
			
			/*
			$i++;
			if ($i == count($rows)) echo '<li style="border-bottom: none;"><a href="/catalog/'.$row['PosID'].'/"><div>'.$row['PosName'].'</div></a></li>';
			else echo '<li><a href="/catalog/'.$row['PosID'].'/"><div>'.$row['PosName'].'</div></a></li>';*/
			?>
			
		<?php endforeach;?>
		<?php
			echo $firstelem;
			echo $nextelem;
		?>
		</ul>
	</div>
			
	
<?php endif; ?>


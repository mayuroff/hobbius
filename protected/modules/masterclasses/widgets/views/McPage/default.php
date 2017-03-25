<?php if(isset($rows) && isset($count) && ($rows != array()) && ($id_next == 0)): ?>
	<div class="newspage">
		<h1>Мастер-классы</h1>
		<?php foreach ($rows as $row): ?>

			<div class="newsone">
				<div class="newsimg">
					<a href="/master-classes/<?php echo $row['id']; ?>/"><img style="width:104px;" src="/images/mc/<?php echo $row['id']; ?>/mc_small_<?php echo $row['id']; ?>.jpg"></a>
				</div>
				<div class="newstxt">
					<div class="newstitle"><a href="/master-classes/<?php echo $row['id']; ?>/"><?php echo $row['title'] ?></a></div>
					<div class="newsdesc"><?php echo $row['short_tekst']; ?></div>
					<div class="newsabout"><a href="/master-classes/<?php echo $row['id']; ?>/">Подробнее &raquo;</a></div>
				</div>
			</div>
			<div class="both"></div>
			
		<?php endforeach;?>
		
		<?php 
		
		if ($page_num > 1) {
			echo '<div class="newspag"><ul>';
			if ($page_now != 0) {
				$pagenext = $page_now;
				if ($pagenext <2) echo '<li class="newspagl"><a href="/master-classes/"><img src="/src/img/pagl.png"></a></li>';
				else echo '<li class="newspagl"><a href="/master-classes/page'.$pagenext.'/"><img src="/src/img/pagl.png"></a></li>';
			}
			for($i=1; $i<=$page_num; $i++) {
				if ($page_now + 1 == $i) echo '<li class="newspagin">'.$i.'</li>';
				elseif ($i < 2) echo '<li class="newspagn"><a href="/master-classes/">'.$i.'</a></li>';
				else echo '<li class="newspagn"><a href="/master-classes/page'.$i.'/">'.$i.'</a></li>';
			}
			if ($page_now+1 != $page_num) {$pagenext = $page_now + 2; echo '<li class="newspagr"><a href="/master-classes/page'.$pagenext.'/"><img src="/src/img/pagr.png"></a></li>';}
			echo '</ul></div>';
		}
		
		?>
			
	</div>
<?php endif; ?>



<?php if(isset($rows) && isset($count) && ($rows != array()) && ($id_next != 0)): ?>
	<div class="newspage">
		<?php foreach ($rows as $row): ?>
			<h1><?php echo $row['title'];?></h1>
			<?php echo $row['tekst'];?>
		<?php endforeach; ?>
			
	</div>
<?php endif; ?>
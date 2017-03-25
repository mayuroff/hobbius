<?php if(isset($rows) && isset($count) && ($rows != array()) && ($id_next == 0)): ?>
	<div class="newspage">
		<h1>Новости</h1>
		<?php foreach ($rows as $row): ?>
			<?php
				//$row['title'] = iconv("windows-1251", "utf-8", html_entity_decode($row['title']));
				//$row['news'] = iconv("windows-1251", "utf-8", html_entity_decode($row['news']));
			?>

			<div class="newsone">
				<div class="newsimg">
					<a href="/news/<?php echo $row['id']; ?>/"><img src="/images/news/<?php echo $row['id']; ?>/news_small_<?php echo $row['id']; ?>.jpg"></a>
				</div>
				<div class="newstxt">
					<div class="newstitle"><a href="/news/<?php echo $row['id']; ?>/"><?php echo $row['title'] ?></a></div>
					<div class="newsdate"><?php echo date("d.m.Y, H:i",$row['time']); ?></div>
					<div class="newsdesc"><?php echo $row['short_news']; ?></div>
					<div class="newsabout"><a href="/news/<?php echo $row['id']; ?>/">Подробнее &raquo;</a></div>
				</div>
			</div>
			<div class="both"></div>
			
		<?php endforeach;?>
		
		<?php 
		
		if ($page_num > 1) {
			echo '<div class="newspag"><ul>';
			if ($page_now != 0) {
				$pagenext = $page_now;
				if ($pagenext <2) echo '<li class="newspagl"><a href="/news/"><img src="/src/img/pagl.png"></a></li>';
				else echo '<li class="newspagl"><a href="/news/page'.$pagenext.'/"><img src="/src/img/pagl.png"></a></li>';
			}
			for($i=1; $i<=$page_num; $i++) {
				if ($page_now + 1 == $i) echo '<li class="newspagin">'.$i.'</li>';
				elseif ($i < 2) echo '<li class="newspagn"><a href="/news/">'.$i.'</a></li>';
				else echo '<li class="newspagn"><a href="/news/page'.$i.'/">'.$i.'</a></li>';
			}
			if ($page_now+1 != $page_num) {$pagenext = $page_now + 2; echo '<li class="newspagr"><a href="/news/page'.$pagenext.'/"><img src="/src/img/pagr.png"></a></li>';}
			echo '</ul></div>';
		}
		
		?>
			
	</div>
<?php endif; ?>



<?php if(isset($rows) && isset($count) && ($rows != array()) && ($id_next != 0)): ?>
	<div class="newspage">
		<h1>Новости</h1>
		
		<?php foreach ($rows as $row): ?>
			<?php echo $row['news'];?>
		<?php endforeach; ?>
			
	</div>
<?php endif; ?>
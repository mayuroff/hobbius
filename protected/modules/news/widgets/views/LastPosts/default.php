<?php if(isset($rows) && $rows != array()): ?>
		<?php 
			echo '<div class="news"><div class="news-title">Наши новости</div>';
			$i = 0;
			foreach ($rows as $row): 
				$i++;
				$datenews = date("d.m.Y, H:i",$row['time']);
				echo'
				<div class="news-block">
					<a href="/news/'.$row['id'].'/">
						<img src="/images/news/'.$row['id'].'/news_smin_'.$row['id'].'.jpg" />
						<b>'.$row['title'].'</b><br />
						<div class="time">'.$datenews.'</div>
						'.$row['short_news'].'
					</a>
				</div>';
				if ($i != $limit) echo'<div class="line"></div>';
			endforeach;  
			echo '</div>';
		?>
<?php endif; ?>
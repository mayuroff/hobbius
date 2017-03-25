<?php if(isset($rows) && $rows != array()): ?>
		<?php 
			echo '<div class="main-mk"><div class="main-mk-head">Мастер-классы</div><div class="main-mk-line"></div>';
			$i = 0;
			foreach ($rows as $row): 
				$i++;
				$second = "";
				if ($i%2 == 0){
					//четное
					$second = " main-mk-second";
				}
				$datenews = date("d.m.Y, H:i",$row['time']);
				echo'
				<div class="main-mk-view'.$second.'">
					<div class="main-mk-img'.$second.'">
						<img src="/images/mc/'.$row['id'].'/mc_small_'.$row['id'].'.jpg" />
						<div class="main-mk-rama"></div>
					</div>
					<div class="main-mk-text">
						<p>'.$row['title'].'</p>
						'.$row['short_tekst'].'
						<br /><a href="/master-classes/'.$row['id'].'/"><div class="main-mk-detail"></div></a>
					</div>
				</div>';
			endforeach;  
			echo '</div>';
		?>
<?php endif; ?>
Шаблон-Начало<br />

<?php if(isset($rows)): ?>
	<?php foreach ($rows as $row): ?>
		<?php echo $row['content']; ?>
	<?php endforeach;?>
<?php endif; ?>

<br />Шаблон-Конец
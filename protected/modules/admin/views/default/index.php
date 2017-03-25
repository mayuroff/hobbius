<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	'Главная',
);
?>

<?php
if(Yii::app()->user->checkAccess('role_page'))
{
	echo "<h2>Добро пожаловать! Хозяин вернулся!</h2>";

	ob_start();
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'error404-grid',
		'dataProvider'=>$model->search(),

		'columns'=>array(
			'id',
			'urlpage',
			array(
				'name'  => 'Дата',
				'type'  => 'raw',
				'value' => 'date("d-m-Y H:i:s",$data["time"])',
			),
		),
	)); 
	$tabs = ob_get_clean();
	
	ob_start();
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'passselect-grid',
		'dataProvider'=>$model2->search2(),
	
		'columns'=>array(
			'id',
			'login',
			'pass',
			array(
				'name'  => 'Дата',
				'type'  => 'raw',
				'value' => 'date("d-m-Y H:i:s",$data["moment"])',
			),
		),
	)); 
	$tabs2 = ob_get_clean();
	
	$str = "
	<ul>
		<li>assets - <b>Временные файлы, ресурсы(image,css,js и др.) находящиеся в папке protected</b></li>

		<li>framework - <b>Файлы фреймворка Yii</b></li>
		<li>images</li>
		<li>protected</li>
			<ul>
				<li>components</li>
				<ul>
					<li>Controller.php - <b>Главный контроллер сайта</b></li>
					<li>fieldEditor.php - <b>Настройки графического редактора FieldEditor</b></li>
					<li>ModuleAdminController.php - <b>Главный контроллер админки сайта</b></li>
					<li>UrlManager.php - <b>Настройки управления Url сайта</b></li>
				</ul>
				<li>config</li>
				<ul>
					<li>db.php - <b>Настройка БД</b></li>
					<li>main.php - <b>Главный конфигурационный файл</b></li>
				</ul>
				<li>controllers</li>
				<ul>
					<li>AjaxController.php - <b>Все ajax функции</b></li>
					<li>SiteController.php - <b>Контроллер сайта</b></li>
				</ul>
				<li>extensions - <b>Подключение библиотек</b></li>
				<ul>
					<li>bootstrap</li>
					<li>ckeditor</li>
					<li>imageCrop</li>
				</ul>
				<li>modules</li>
				<ul>
					<li>admin - <b>Главная страница админки, шаблоны админки</b></li>
					<li>adminuser - <b>Пользователи админки</b></li>
					<li>articles - <b>Статьи</b></li>
					<li>catalog - <b>Каталог товаров</b></li>
					<li>layouts - <b>Шаблоны сайта</b></li>
					<li>masterclasses - <b>Мастер-классы</b></li>
					<li>news - <b>Новости</b></li>
					<li>sitepages - <b>Страницы сайта</b></li>
				</ul>
				<li>runtime - <b>Временные файлы Yii, файлы логов</b></li>
			</ul>
		<li>src</li>
			<ul>
				<li>css</li>
				<li>font</li>
				<li>img</li>
				<li>js</li>
			</ul>
		<li>themes</li>
			<ul>
				<li>bootstrap</li>
				<ul>
					<li>css</li>
					<li>views</li>
					<ul>
						<li>layouts - <b>Файлы шаблонов сайта</b></li>
						<li>site - <b>Страницы error404, sitemap</b></li>
					</ul>
				</ul>
			</ul>
		<li>index.php - <b>Главный скрипт, переадресация 301 со старых страниц</b></li>
	</ul>
	<br /><br /><br /><br />
	";
	
	$this->widget('bootstrap.widgets.TbTabs', array(
    'type'=>'tabs', // 'tabs' or 'pills'
    'tabs'=>array(
        array('label'=>'Ошибки 404', 'content'=>$tabs, 'active'=>true),
        array('label'=>'Структура сайта', 'content'=>$str),
        array('label'=>'Подбор пароля админки', 'content'=>$tabs2),
    ),
));
	
	
	
}
else
{
	echo "<h2>Добро пожаловать!</h2>";
	echo "<b>По всем вопросам, предложениям и пожеланиям обращаться: web@firma-gamma.ru</b><br /><br /><br /><br />";
}
?>
<?php

class FrontendController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/layoutSitePage1';
	
    public $mainpage = 0;
	public $pageTitle = 'Hobbius';
	public $pageDescription = '';
    public $pageKeywords = '';
    public $title = '';
    public $content = '';
    public $pageClass = '';

	public $_level = 0;
	public $_idgood = 0;
	public $_page = 1;
	public $_idsubgood = 0;
	public $_basketdel = 0;
	public $_clear = 0;
	public $_inshops = 0;
	public $_spc = 0;
	public $_cards = 0;
	public $_sitepage = 0;
	public $_sitepageurl = "nulltxt";
	public $_titlepage = "";
	public $_idtree = 0;
    
    public function init(){
        // SET THEME desktop/mobile
        $device = Yii::app()->mobileDetect;
        if($device->isMobile() || $device->isIphone()){
            Yii::app()->theme = 'mobile';    
        }
        elseif($device->isTablet()){
            Yii::app()->theme = 'tablet'; 
        }
        else{
            Yii::app()->theme = 'desktop'; 
        }
    }
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('tree','index','view'),
				'users'=>array('*'),
			),
		);
	}

	public function parseTreeId($idtree)
	{
		//$my_tree = "tree_";
		$my_page = "page";
		$my_basketdel = "basketdel";
		$my_clear = "clear";
		$mas = explode('/', $idtree, 10);
		$basket = "basket";
		$inshops = "inshops";
		$my_spc = "spc";
		$my_cards = "cards";
		$poz_basket = strpos($mas[0], $basket);
		$poz_inshops = strpos($mas[0], $inshops);
		if ($poz_basket !== false)
			{
			//корзина
			$poz_page = false;
			$poz_basketdel = false;
			$poz_clear = false;
			if (count($mas) > 1)
				{
				$poz_basketdel = strpos($mas[1], $my_basketdel);
				$poz_page = strpos($mas[1], $my_page);
				$poz_clear = strpos($mas[1], $my_clear);
				if ($poz_clear !== false) $this->_clear = 1;
				if ($poz_basketdel !== false) $this->_basketdel = substr($mas[1],strlen($my_basketdel), strlen($mas[1]));
				if ($poz_page !== false) $this->_page = substr($mas[1],strlen($my_page), strlen($mas[1]));
				if ( (!is_numeric($this->_page)) || (!is_numeric($this->_basketdel)) ) {$this->redirect(Yii::app()->createUrl('catalog/'.$mas[0]));}
				}
			elseif (count($mas) > 2)
				{
				$poz_basketdel = strpos($mas[1], $my_basketdel);
				$poz_page = strpos($mas[2], $my_page);
				if ($poz_basketdel !== false) $this->_basketdel = substr($mas[1],strlen($my_basketdel), strlen($mas[1]));
				if ($poz_page !== false) $this->_page = substr($mas[2],strlen($my_page), strlen($mas[2]));
				if ( (!is_numeric($this->_page)) || (!is_numeric($this->_basketdel)) ) {$this->redirect(Yii::app()->createUrl('catalog/'.$mas[0]));}
				}
			}
		elseif ($poz_inshops !== false)
			{
			//Просмотр наличия товара в магазинах
			if (count($mas) > 1)
				{
				if (is_numeric($mas[1])) $this->_inshops = $mas[1];
				}
			}
		elseif (!is_numeric($mas[0])) 
			{
			//Значит страница сайта, возможно!
			$this->_sitepage = 1;
			}	
		elseif (count($mas) > 1) 
			{
			//Каталог
			$poz_page = strpos($mas[1], $my_page);
			$poz_spc = strpos($mas[1], $my_spc);
			$poz_cards = strpos($mas[1], $my_cards);
			if ($poz_page !== false)
				{
				$this->_page = substr($mas[1],strlen($my_page), strlen($mas[1]));
				if (!is_numeric($this->_page)) {$this->redirect(Yii::app()->createUrl('catalog/'.$mas[0]));}
				}
			elseif ($poz_spc !== false)
				{
				$this->_spc = substr($mas[1],strlen($my_spc), strlen($mas[1]));
				if (!is_numeric($this->_spc)) {$this->redirect(Yii::app()->createUrl('catalog/'.$mas[0]));}
				}
			elseif ($poz_cards !== false)
				{
				$this->_cards = 1;
				//if (!is_numeric($this->_spc)) {$this->redirect(Yii::app()->createUrl('catalog/'.$mas[0]));}
				}
			elseif (!is_numeric($mas[1])) {$this->redirect(Yii::app()->createUrl('catalog/'.$mas[0]));}
			
			if (count($mas) > 2) 
				{
				//$this->_idsubgood
				$this->_idsubgood = $mas[2];
				if (!is_numeric($this->_idsubgood)) {$this->redirect(Yii::app()->createUrl('catalog/'.$mas[0].'/'.$mas[1]));}
				}
			}
		//пока только 4 параметр!!!
		if (count($mas) > 4) {$this->redirect(Yii::app()->createUrl('catalog/'.$mas[0].'/'.$mas[1].'/'.$mas[2].'/'.$mas[3]));}
		return $mas;
	}
	
	// Загрузка разделов (уровней) по id родителя - Уровни 1,2,3,4...
	public function loadTreeForMas($idtree, $onselid)
	{
		$mas = array();
		if (is_numeric($idtree))
		{
			$sql = "SELECT id_tree, treename FROM {{tree}} WHERE shop_tree_id='".$idtree."' ORDER BY treename";
			$command=Yii::app()->db->createCommand($sql);
			$dataReader=$command->query();
			if (sizeof($dataReader) != 0) $this->_level++;
			foreach($dataReader as $row) 
				{ 
				$onsel = 0;
				//$onlast = 0;
				if ($onselid == $row['id_tree']) 
					{
					$onsel = 1;
					/*
					$sql='SELECT SQL_NO_CACHE id FROM shop_tree WHERE shop_tree_id='.$onselid;
					$command=Yii::app()->db->createCommand($sql);
					$dataReader2 = $command->query();
					if (sizeof($dataReader2) == 0) $onlast = 1;
					*/
					}
				$mas[] = Array($this->_level, $row['id_tree'], $row['treename'], $onsel, 'текст');
				}
		} elseif (strlen($idtree) == 0) {
			$mas[] = "Ошибка №1: id пустое - Такого раздела в каталоге не существует!";
			throw new CHttpException(404,'Страница не найдена! Ошибка №1: id пустое - Такого раздела в каталоге не существует!');
			exit();
		} else {
			$mas[] = "Ошибка №2: id {".$idtree."} должен быть числом!";
			throw new CHttpException(404,'Страница не найдена! Ошибка №1: id должен быть числом!');
			exit();
		}
		return $mas;
	}
	
	// Загрузка предыдущих разделов (уровней) каталога в цикле
	public function loadTreeNext($idtree)
	{
		$mas = array();
		$url_page = $this->parseTreeId($idtree);
		$idtree = $url_page[0];

		$idgood = 0;
		$good = "good_";
		$poz_good = strpos($idtree, $good);
		if ($poz_good !== false)
		{
			$idtree = substr($idtree,strlen($good));
			$this->_idgood = $idtree;
			$idgood = $this->_idgood;
			$idtree = 0;
		}
		else
			$this->_idtree = $idtree;
		
		if (count($url_page) > 1) 
		{
			if (is_numeric($url_page[1])) $this->_idgood = $url_page[1];
		}
		
		//переадресация при отсутствии idtree
		if ( (count($url_page) == 1) && (is_numeric($idtree)) && ($idtree != 0) )
		{
			$sql='SELECT count(*) FROM Goods WHERE PosID='.$idtree;
			$command=Yii::app()->db->createCommand($sql);
			$s=$command->queryScalar();
			if ($s == 0) 
			{
				$base_url = Yii::app()->params['base_url'];
				$pereadres = "Location: ".$base_url."catalog/";
				header("HTTP/1.1 301 Moved Permanently");
				header($pereadres);
				exit;
			}
			//else echo "yyy";
		}
		if ( (count($url_page) == 1) && (is_numeric($idgood)) && ($idgood != 0) )
		{
			$this->layout='//layouts/layoutSitePage1';
			$sql='SELECT * FROM Goods WHERE GoodID='.$idgood;
			$command=Yii::app()->db->createCommand($sql);
			$s=$command->queryAll();
			if (sizeof($s) > 1) {
				foreach($s as $row)
				{
					if ($row['PosID'] == 23675941562) continue;
					$idtree = $row['PosID'];
					$this->_idtree = $idtree;
				}
			} else {
				foreach($s as $row)
				{
					$idtree = $row['PosID'];
					$this->_idtree = $idtree;
				}
			}
		}
		/*
		$basket = "basket";
		$order = "order";
		$poz_basket = strpos($url_page[0], $basket);
		$inshops = "inshops";
		$poz_inshops = strpos($url_page[0], $inshops);
		if ($poz_basket !== false)
		{
			//корзина
			$mas[0] = 1; 
			if (count($url_page)>1)
			{
				$poz_order = strpos($url_page[1], $order);
				if ($poz_order !== false) $mas[0] = 2;
			}
		}
		elseif ($poz_inshops !== false)
		{
			//inshops
			$mas[0] = 3;
		}
		elseif ($this->_sitepage == 1)
		{
			//Страница сайта
			$mas[0] = 4;
			$this->_sitepage = "catalog";
			for($i=0;$i<count($url_page);$i++) $this->_sitepage .= "/".$url_page[$i];
		}
		else 
		{
		*/
			$mas = $this->loadTreeForMas($idtree,0);
			do {
				$sql='SELECT * FROM Menu WHERE PosID='.$idtree;
				$command=Yii::app()->db->createCommand($sql);
				$row = $command->query()->read();
				$shop_tree_id = 0; //на случай вложенного меню
				$a = $this->loadTreeForMas($shop_tree_id, $idtree);
				$this->_titlepage = $this->_titlepage.$row['PosName'];
				$this->_titlepage .= ", ";
				$mas = array_merge($a,$mas);
				$idtree = $shop_tree_id;
			} while ($shop_tree_id != 0);
		//}
		
		return $mas;
	}
	
	// Загрузка страниц каталога с параметрами
	public function actionItem($id)
	{
		$this->pageTitle = "Каталог";
		$this->pageDescription = "Каталог";
		$this->pageKeywords = "Каталог";
		
		$dataReader = $this->loadTreeNext($id);
		if ((count($dataReader) == 1) && ( ($dataReader[0] == 1) || ($dataReader[0] == 2) || ($dataReader[0] == 3) || ($dataReader[0] == 4) ))
		{
			$page = $this->loadModelDop("catalog/".$id);
			if ($page != null)
			{
				$page_main = $this->loadModel('main');
				$page_title = $page_main->title_short;
		
		    	$this->pageTitle = $page->title_short." | ".$page_title;
				$this->pageDescription = $page->description;
		    	$this->pageKeywords = $page->keywords;
			}
    	
			if ($dataReader[0] == 2){
				//Оформление заказа
				$this->render('order');
			} 
			elseif ($dataReader[0] == 3){
				//inshops
				$this->layout='//layouts/layoutNullTitle';
				$this->render('inshops',array(
					'idgood'=>$this->_inshops,
				));
			} 
			elseif ($dataReader[0] == 4){
				//страница сайта
				// загрузим модуль и 
				// /catalog/consult/ :например
				$controller = Yii::app()->createController('sitepages/frontend');
				$controller[0]->actionCategory($this->_sitepage);
			}
			else {
				//корзина
				$this->render('basket',array(
					'page'=>$this->_page,
					'basketdel'=>$this->_basketdel,
					'clear'=>$this->_clear,
				));
			}
		}
        
        $product = array(
            'id' =>  $this->_idgood,
            'name' => '',
            'idtree' =>  $this->_idtree,
            'page' =>  $this->_page,
            'idsubgood' =>  $this->_idsubgood,
            'spc' =>  $this->_spc,
            'cards' =>  $this->_cards,
            'bigimg' => array(),
            'smalimg' => array(),
            'property_str' => '',
            
        );
    
        $sql = 'SELECT Details.DetailID AS GoodID, Details.DetailName AS GoodName FROM Details WHERE DetailID='.$product['id'].';';
        $command = Yii::app()->db->createCommand($sql);
        $rows = $command->queryAll();
        if (count($rows) > 0)
        {
            $product['name'] = $rows[0]['GoodName'];
            
            $i = 0;
            
            $sql='SELECT t2.FileName FROM images.detail_photo AS t2 WHERE DetailId='.$product['id'].' AND PhotoQualityId<3 ORDER BY FileName';
            $command = Yii::app()->db->createCommand($sql);
            $imglist = $command->queryAll();
            
            foreach($imglist as $img)
            {
                $img['FileName']=str_replace('\\_','_',$img['FileName']);
                if(preg_match('/^d[0-9_]+.jpg$/',$img['FileName']))continue;
                if(preg_match('/^df[0-9_]+.jpg$/',$img['FileName']))continue;
                
                $mm = md5($img['FileName']);
                $img_filename = $mm[0].'/'.$mm[1].'/'.$img['FileName'];
                
                $product['bigimg'][] = 'http://images.firma-gamma.ru/400x400/'.$img_filename;
                $product['smalimg'][] = 'http://images.firma-gamma.ru/100x100/'.$img_filename;
                
                $i++;
                if ($i>3)break;
            }
            if (count($product['bigimg']) == 0){
                for($i = 0; $i < 3; $i++){
                    $product['bigimg'][] = '/src/img/losutnoe_shitie-crop-u17026.jpg';
                    $product['smalimg'][] = '/src/img/losutnoe_shitie-crop-u17026.jpg';
                }
            }
            
            $sql = 'SELECT * FROM PropertyD,PropertyItemD WHERE (DetailID='.$product['id'].') and (PropertyD.PropertyID = PropertyItemD.PropertyID)';
            $command = Yii::app()->db->createCommand($sql);
            $properties = $command->queryAll();
            
            $property_count = count($properties);
            $level = 0;
            $article = "";
            $marka = "";
        
            foreach($properties as $property)
            {
                if ($property['PropertyName']=='Сертификация')continue;
                if ($property['PropertyName']=='Назначение')continue;
                if ($property['PropertyName']=='Производитель')continue;
                if ($property['PropertyName']=='Наименование')continue;
                if ($property['PropertyName']=='Объем единицы продажи, л')continue;
                if ($property['PropertyName']=='Вес единицы продажи (кг)')continue;
                if ($property['PropertyName']=='Наше производство')continue;
                if ($property['PropertyName']=='Наложенный платеж Иголочка')continue;
                if ($property['PropertyName']=='Акция Опт')continue;
                if ($property['PropertyName']=='Каталог Miadolla.com')continue;
                if ($property['PropertyName']=='Дата СК')continue;
                if ($property['PropertyName']=='Распродажа')continue;
                
                if ($property['PropertyID'] == 32397) continue; //Количество, шт
                if ($property['PropertyID'] == 1) continue; //Прочее
                
                if ($property['PropertyID'] == 1) {
                    $article = $property['Value']; 
                    $product['property_str'] .= '<tr><td>'.$property['PropertyName'].'</td><td>'.$property['Value'].'</td></tr>'; 
                    continue;
                }
                if ($property['PropertyID'] == 19) {
                    $marka = $property['Value']; 
                    continue;
                }
                
                if ($property['PropertyID'] == 23284540172) {
                    $product['property_str'] .= '<tr><td>'.$property['PropertyName'].'</td><td>'.$property['Value'].'</td></tr>'; 
                    continue;
                }
                if ($property['PropertyID'] == 26722442852) {
                    $product['property_str'] .= '<tr><td>'.$property['PropertyName'].'</td><td>'.$property['Value'].'</td></tr>'; 
                    continue;
                }

                $product['property_str'] .= '<tr><td>'.$property['PropertyName'].'</td><td>'.$property['Value'].'</td></tr>';
            }
        
            $this->pageTitle = ''.$product['name'].' '.$article.' | Кристальная мозаика Фрея - официальный сайт';
        }
        
        $this->pageClass = 'catalog-item'; 
        
        $layoutFile = $this->getLayoutFile('//layouts/layoutCatalogItem');              
        $this->renderFile($layoutFile, array('product' => $product)); 
	}

	// Загрузка главной страницы каталога
	public function actionList()
	{	
    	$page = $this->loadModel('catalog');

        $sql = 'SELECT Details.DetailID AS GoodID, Details.DetailName AS GoodName FROM Details';
        $command = Yii::app()->db->createCommand($sql);
        $rows = $command->queryAll();
        
        $products = array();
        
        foreach($rows as $row) {
        
            $product = array(
                'id' =>  $row['GoodID'],
                'name' => $row['GoodName'],
                'bigimg' => '',
                'property_str' => '',
            );
            
            $sql = 'SELECT t2.FileName FROM images.detail_photo AS t2 WHERE DetailId='.$product['id'].' AND PhotoQualityId<3 ORDER BY FileName';
            $command = Yii::app()->db->createCommand($sql);
            $imglist = $command->queryAll();
            
            foreach($imglist as $img){
                $img['FileName'] = str_replace('\\_','_',$img['FileName']);
                if(preg_match('/^d[0-9_]+.jpg$/',$img['FileName']))continue;
                
                $mm = md5($img['FileName']);
                $img_filename = $mm[0].'/'.$mm[1].'/'.$img['FileName'];
                $product['bigimg'] = 'http://images.firma-gamma.ru/400x400/'.$img_filename;
                
                break;
            }
            
            if (strlen($product['bigimg']) == 0){
                $product['bigimg'] = '/src/img/tovar.jpg';
            }
            
            $products[] = $product;
        }

        $this->pageTitle = $page->title_short;
        $this->pageDescription = $page->description;
        $this->pageKeywords = $page->keywords;
        
        $this->title = $page->title_for_admin;
        
        $this->pageClass = 'catalog';     
    	
        $layoutFile = $this->getLayoutFile('//layouts/layoutCatalogList');              
        $this->renderFile($layoutFile, array('products' => $products)); 
	}

	
	public function loadModel($id)
	{
		$model = FrontendSitepages::model()->findBySlug($id);
		if($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModelDop($id)
	{
		$model = FrontendSitepages::model()->findBySlug($id);
		if($model === null)
			return null;
		return $model;
	}
}

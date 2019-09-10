<?php
require_once 'ApiController.php';

class InfoApi extends ApiController
{
    public $apiName = 'info';

    /**
     * Метод GET
     * получение параметров отдельных страниц и их элементов
     * http://ДОМЕН/api/info/infoName
     */
    public function indexAction()
    {
        return $this->response('Error. Required parameter: infoName', 400);
    }

    public function viewAction()
    {
        $name = array_shift($this->requestUri);

        if($name == 'main'){
			$company = q1("SELECT title, txt, img FROM texts WHERE id='6'", []);
			$categories = q("SELECT * FROM categories ORDER BY orderby", []);
			$collections = q("SELECT * FROM collections ORDER BY orderby", []);
			if($categories||$collections||$company){
				$result = [];
				$result['info'] = $company;
				$result['categories'] = $categories;
				$result['collections'] = $collections;
				return $this->response($result, 200);
			}
        } elseif ($name == 'about'){
			$about = q1("SELECT title, txt FROM texts WHERE id='1'", []);		
			$about_images = q("SELECT img FROM about_images WHERE is_visible='1' ORDER BY orderby", []);
			if($about){
				$main_image = array_shift($about_images);
				$result = [];
				$result['info'] = $about;
				$result['main_image'] = $main_image;
				$result['images'] = $about_images;
				return $this->response($result, 200);
			}
		} elseif ($name == 'contacts'){
			$contacts = q1("SELECT * FROM contacts WHERE id='1'", []);
			if($contacts){
				return $this->response($contacts, 200);
			}
		} elseif ($name == 'privacy'){
			$privacy = q1("SELECT title, txt FROM texts WHERE id='4'", []);
			if($privacy){
				return $this->response($privacy, 200);
			}			
		} elseif ($name == 'services'){
			$payment = q1("SELECT title, txt FROM texts WHERE id='2'", []);
			$delivery = q1("SELECT title, txt FROM texts WHERE id='3'", []);
			$result = [];
			if($payment){
				$result['payment'] = $payment;
			}
			if($delivery){
				$result['delivery'] = $delivery;
			}
			if($payment || $delivery){
				return $this->response($result, 200);
			}
		} elseif ($name == 'lookbook'){
			$lookbook = q1("SELECT title, txt FROM texts WHERE id='5'", []);	
			$lookbook_images = q("SELECT img FROM lookbook_images WHERE is_visible='1' ORDER BY orderby", []);
			if($lookbook){
				$main_image = array_shift($lookbook_images);
				$result = [];
				$result['info'] = $lookbook;
				$result['main_image'] = $main_image;
				$result['images'] = $lookbook_images;
				return $this->response($result, 200);
			}			
		} elseif ($name == 'header'){
			$arItems = q("SELECT `id`, `orderby`, `name`, `link`, IFNULL(`parent_id`, '0') AS `parent_id` FROM `nav` WHERE `display_in_menu`='1'  UNION SELECT CONCAT('collection_', `id`) AS `id`, `orderby`, `name`, '' AS `link`, '3' AS `parent_id` FROM `collections` WHERE display_in_menu='1' UNION SELECT CONCAT('category_', `id`) AS `id`, `orderby`, `name`, '' AS `link`, '2' AS `parent_id` FROM `categories` WHERE display_in_menu='1' UNION SELECT CONCAT('article_', `id`) AS `id`, `orderby`, `title` AS `name`, '' AS `link`, '7' AS `parent_id` FROM `articles` WHERE display_in_menu='1' ORDER by `orderby`", []);
			
			$i = 0;
			
			foreach ($arItems as $item) {
				
				if (!is_numeric($item['id'])) {
					
					$item['link'] = (string) $item['name']; // преобразуем в строковое значение
					$item['link'] = strip_tags($item['link']); // убираем HTML-теги
					$item['link'] = str_replace(array("\n", "\r"), " ", $item['link']); // убираем перевод каретки
					$item['link'] = preg_replace("/\s+/", ' ', $item['link']); // удаляем повторяющие пробелы
					$item['link'] = trim($item['link']); // убираем пробелы в начале и конце строки
					$item['link'] = function_exists('mb_strtolower') ? mb_strtolower($item['link']) : strtolower($item['link']); // переводим строку в нижний регистр (иногда надо задать локаль)
					$item['link'] = preg_replace('/[^ a-zа-яё\d]/ui', '',$item['link']); // очищаем строку от недопустимых символов
					$item['link'] = str_replace(" ", "-", $item['link']); // заменяем пробелы знаком минус
					
					
					$arItems[$i]['link'] = $item['link'];
					
					if ($item['parent_id'] == '2') {
						$arItems[$i]['link'] = "/категория/".$arItems[$i]['link'];
					} elseif ($item['parent_id'] == '3') {
						$arItems[$i]['link'] = "/коллекция/".$arItems[$i]['link'];
					} elseif ($item['parent_id'] == '7') {
						$arItems[$i]['link'] = "/статья/".$arItems[$i]['link'];
					}
				}
				
				$i++;
			}
			
			if($arItems){
			
				function buildTreeArray($arItems, $section_id = 'parent_id', $element_id = 'id') {
					$childs = array();
					if(!is_array($arItems) || empty($arItems)) {
						return array();
					}
					foreach($arItems as &$item) {
						if(!$item[$section_id]) {
							$item[$section_id] = 0;
						}
						$childs[$item[$section_id]][] = &$item;
					}
					unset($item);
					foreach($arItems as &$item) {
						if (isset($childs[$item[$element_id]])) {
							$item['childs'] = $childs[$item[$element_id]];
						}
					}
					return $childs[0];
				}
				
				$menu = buildTreeArray($arItems);

				$result['nav'] = $menu;
				return $this->response($result, 200);
			}		
		} elseif ($name == 'articles'){
			$articles = q("SELECT * FROM articles ORDER BY orderby", []);
			if($articles){
				return $this->response($articles, 200);
			}			
		} elseif ($name == 'article'){
			$id = array_shift($this->requestUri);
			if($id){
				$article = q1("SELECT * FROM articles WHERE id=?", [$id]);
				
				if($article){
					return $this->response($article, 200);
				}
			}			
		} elseif ($name == 'social'){
			$social_links = q("SELECT * FROM social_links WHERE is_display='1' ORDER BY orderby",[]);	
			if($social_links){
				return $this->response($social_links, 200);
			}			
		} elseif ($name == 'slider'){
			$main_slider = q("SELECT * FROM main_slider WHERE is_visible='1' ORDER BY is_video, orderby",[]);	
			if($main_slider){
				return $this->response($main_slider, 200);
			}			
		}
        return $this->response('Data not found', 404);
    }

    public function createAction()
    {
        return $this->response("Saving error", 500);
    }

}
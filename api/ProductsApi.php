<?php
require_once 'ApiController.php';

class ProductsApi extends ApiController
{
    public $apiName = 'products';

    /**
     * Метод GET
     * Вывод списка всех товаров
     * http://ДОМЕН/api/products
     */
    public function indexAction()
    {
        $products = q("SELECT * FROM products", []);
        if($products){
            return $this->response($products, 200);
        }
        return $this->response('Data not found', 404);
    }

    /**
     * Метод GET
     * Просмотр товаров отдельной таксономии, новинок и поиск
     * http://ДОМЕН/api/products/category/1/1/
     */
    public function viewAction()
    {
        //type должен быть первым параметром после /products/x
        $type = array_shift($this->requestUri);
		
		$second = array_shift($this->requestUri);
		
		$third = array_shift($this->requestUri);

        if($type == 'category'){
			$id = $second;
			$page = $third;
			if($id){
				if($page){
					$limit = (($page - 1) * itemInPage).", ". itemInPage;
					$products = q("SELECT * FROM products WHERE category_id=? AND is_visible='1' LIMIT {$limit}", [$id]);
				} else {
					$products = q("SELECT * FROM products WHERE category_id=? AND is_visible='1'", [$id]);
				}
				if($products){
					$category = q1("SELECT * FROM categories WHERE id=?", [$id]);
					$count = q1("SELECT COUNT(id) AS cnt FROM products WHERE category_id=? GROUP BY category_id", [$id]);
					$result = [];
					$result['products'] = $products;
					$result['info'] = $category;
					$result['total'] = $count['cnt'];
					return $this->response($result, 200);
				}
				
			}
        } elseif($type == 'collection'){
			$id = $second;
			$page = $third;
			if($id){
				if($page){
					$limit = (($page - 1) * itemInPage).", ". itemInPage;
					$products = q("SELECT * FROM products WHERE id IN (SELECT product_id FROM products_collections WHERE collection_id=?) AND is_visible='1' LIMIT {$limit}", [$id]);
				} else {
					$products = q("SELECT * FROM products WHERE id IN (SELECT product_id FROM products_collections WHERE collection_id=?) AND is_visible='1'", [$id]);
				}
				if($products){
					$collection = q1("SELECT * FROM collections WHERE id=?", [$id]);
					$count = q1("SELECT COUNT(p.id) AS cnt FROM products AS p LEFT JOIN collections AS c ON (c.id=?) WHERE p.id IN (SELECT product_id FROM products_collections WHERE collection_id=?) AND p.is_visible='1' GROUP BY c.id", [$id, $id]);
					$result = [];
					$result['products'] = $products;
					$result['info'] = $collection;
					$result['total'] = $count['cnt'];
					return $this->response($result, 200);
				}
			}
		} elseif($type == 'new'){
			$page = $second;
			if($page){
				$limit = (($page - 1) * itemInPage).", ". itemInPage;
				$products = q("SELECT * FROM products WHERE is_new='1' AND is_visible='1' ORDER BY id DESC LIMIT {$limit}", []);
			} else {
				$products = q("SELECT * FROM products WHERE is_new='1' AND is_visible='1' ORDER BY id DESC", []);
			}
			if($products){
				$count = q1("SELECT COUNT(id) AS cnt FROM products WHERE is_new='1' AND is_visible='1' GROUP BY is_new", []);
				$result = [];
				$result['products'] = $products;
				$result['info'] = "Новые поступления";
				$result['total'] = $count['cnt'];
				return $this->response($result, 200);
			}
		} elseif($type == 'search'){
			$search = $this->requestParams['s'] ?? '';
			$page = $this->requestParams['page'] ?? '';
			if($search){
				if($page){
					$limit = (($page - 1) * itemInPage).", ". itemInPage;
					$products = q("SELECT * FROM products WHERE name LIKE '%{$search}%' OR txt LIKE '%{$search}%' AND is_visible='1' LIMIT {$limit}", []);
				} else {
					$products = q("SELECT * FROM products WHERE name LIKE '%{$search}%' OR txt LIKE '%{$search}%' AND is_visible='1'", []);
				}
				if($products){
					$count = q1("SELECT COUNT(id) AS cnt FROM products WHERE name LIKE '%{$search}%' OR txt LIKE '%{$search}%' AND is_visible='1'", []);
					$result = [];
					$result['products'] = $products;
					$result['info'] = "Результаты поиска";
					$result['total'] = $count['cnt'];
					return $this->response($result, 200);
				}
			}
		}
        return $this->response('Data not found', 404);
    }

    public function createAction()
    {
        return $this->response("Saving error", 500);
    }

    

}
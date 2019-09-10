<?php
require_once 'ApiController.php';

class ProductApi extends ApiController
{
    public $apiName = 'product';

    /**
     * Метод GET
     * Просмотр отдельного товара (по id)
     * http://ДОМЕН/api/product/1
     */
	public function indexAction()
    {
        return $this->response('Error. Required parameter: ID', 400);
    }

    public function viewAction()
    {
        //id должен быть первым параметром после /product/x
        $id = array_shift($this->requestUri);

        if($id){
			$product = q1("SELECT p.id, p.category_id, c.name AS category_name, p.name, p.txt, p.is_new, p.price FROM products AS p LEFT JOIN categories AS c ON (c.id=p.category_id) WHERE p.id=? AND p.is_visible='1'", [$id]);
			$product_images = q("SELECT * FROM products_gallery WHERE product_id=? AND is_visible='1' ORDER BY orderby", [$id]);
			$products_attributes = q("SELECT a.name, av.attribute_value AS `value`, pav.price_delta AS price, pa.id AS attr_id, pav.id AS value_id FROM products_attributes AS pa LEFT JOIN attributes AS a ON (pa.attribute_id=a.id) LEFT JOIN products_attributes_values AS pav ON (pav.product_attribute_id=pa.id) LEFT JOIN attributes_values AS av ON (av.id=pav.attribute_value_id) WHERE pa.product_id=? AND pa.is_visible='1' ORDER BY a.id, av.attribute_value", [$id]);
			$attributes = [];
			$i = -1;
			$j = 0;
			$name = '';
			foreach ($products_attributes as $pa) {
								
				if($pa['name'] != $name) {
					$i++;
					$j = 0;
					$attributes[$i]['name'] = $pa['name'];
					$attributes[$i]['attr_id'] = $pa['attr_id'];
					$name = $pa['name'];					
				}
				
				unset($pa['name']);
				unset($pa['attr_id']);
				
				$attributes[$i]['values'][$j] = $pa;

				$j++;
			}
			
			if($product){
				$result = [];
				$result['info'] = $product;
				$result['images'] = $product_images;
				$result['attributes'] = $attributes;
				return $this->response($result, 200);
			}
        } 
        return $this->response('Data not found', 404);
    }


    public function createAction()
    {
        return $this->response("Saving error", 500);
    }

    

}
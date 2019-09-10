<?php
require_once 'ApiController.php';

class OrderApi extends ApiController
{
    public $apiName = 'order';


	public function indexAction()
    {
        return $this->response('Error. Bad Request', 400);
    }

    public function viewAction()
    {
        return $this->response('Error. Bad Request', 400);
    }

    /**
     * Метод POST
     * Создание новой записи
     * http://ДОМЕН/api/order/ + параметры запроса id, name, phone, email, address, msg, payment_type, delivery_type, products[]
     * @return string = id заказа
     */
    public function createAction()
    {
		$id = $this->requestParams['id'] ?? '';
        $name = $this->requestParams['name'] ?? '';
        $phone = $this->requestParams['phone'] ?? '';
		$email = $this->requestParams['email'] ?? '';
		$address = $this->requestParams['address'] ?? '';
		$msg = $this->requestParams['msg'] ?? '';
		$payment_type = $this->requestParams['payment_type'] ?? '';
		$delivery_type = $this->requestParams['delivery_type'] ?? '';
		$products = $this->requestParams['products'] ?? '';
        if($name && $phone && $address && $payment_type && $delivery_type){
			
			if (!$email) {$email = '';}
			if (!$msg) {$msg = '';}
			
			qi("UPDATE orders SET `name`=?, `phone`=?, `email`=?, `address`=?, `msg`=?, `payment_type`=?, `delivery_type`=? WHERE `id`=?", [$name, $phone, $email, $address, $msg, $payment_type, $delivery_type, $id]);
						
			$products = json_decode($products, true);
						
			foreach ($products as $product){
				
				$product_current = q1("SELECT price FROM products WHERE id=?", [$product['id']]);
									
				qi("INSERT INTO orders_products (`order_id`, `product_id`, `current_price`) VALUES (?, ?, ?)", [$id, $product['id'], $product_current['price']]);
				
				$last_order_product_id = qInsertId();
				
				$attributes = $product['attributes'];
				
				if($last_order_product_id != '0'){
				
					foreach ($attributes as $attr) {
						
						$current_value = q1("SELECT price_delta FROM products_attributes_values WHERE id=?", [$attr['value_id']]);
						
						qi("INSERT INTO orders_options (`order_id`, `order_product_id`, `product_attribute_id`, `product_attribute_value_id`, `current_price`) VALUES (?, ?, ?, ?, ?)", [$id, $last_order_product_id, $attr['attr_id'], $attr['value_id'], $current_value['price_delta']]);
						
					}
				}
			}	
            return $this->response("Data saved", 200);
        }
        return $this->response("Saving error", 500);
    }

    

}
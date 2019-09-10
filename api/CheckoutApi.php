<?php
require_once 'ApiController.php';

class CheckoutApi extends ApiController
{
    public $apiName = 'checkout';


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
     * Создание пустого заказа в момент начала оформления заказа для получения номера заказа
     * http://ДОМЕН/api/order/ + параметры запроса name, phone, email, address, msg, payment_type, delivery_type, products[]
     * @return string = id заказа
     */
    public function createAction()
    {    
		qi("INSERT INTO orders (`name`, `phone`, `email`, `address`, `msg`, `payment_type`, `delivery_type`) VALUES (?, ?, ?, ?, ?, ?, ?)", ['', '', '', '', '', '', '']);
		
		$last_id = qInsertId();
		
        if($last_id != '0'){
						
            return $this->response($last_id, 200);
        }
        
        return $this->response("Saving error", 500);
    }

    

}
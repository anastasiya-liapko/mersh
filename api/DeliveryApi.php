<?php
require_once 'ApiController.php';

class DeliveryApi extends ApiController
{
    public $apiName = 'delivery';

    /**
     * Метод GET
     * Просмотр способов доставки
     * http://ДОМЕН/api/delivery/
     */
	public function indexAction()
    {
        $delivery = q("SELECT id, name, price FROM delivery WHERE is_visible='1'", []);
        if($delivery){
            return $this->response($delivery, 200);
        }
        return $this->response('Data not found', 404);
    }

    public function viewAction()
    {
        return $this->response('Error. Method does not support any parameters', 400);
    }


    public function createAction()
    {
        return $this->response("Saving error", 500);
    }

    

}
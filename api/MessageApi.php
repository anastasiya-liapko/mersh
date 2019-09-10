<?php
require_once 'ApiController.php';

class MessageApi extends ApiController
{
    public $apiName = 'message';


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
     * http://ДОМЕН/api/message/ + параметры запроса name, phone, email, msg
     * @return string
     */
    public function createAction()
    {
        $name = $this->requestParams['name'] ?? '';
        $phone = $this->requestParams['phone'] ?? '';
		$email = $this->requestParams['email'] ?? '';
		$msg = $this->requestParams['msg'] ?? '';
        if($name && $phone && $email && $msg){
			
			qi("INSERT INTO individual_orders (`name`, `phone`, `email`, `msg`) VALUES (?, ?, ?, ?)", [$name, $phone, $email, $msg]);
			
			$last_id = qInsertId();
			
            if($last_id != '0'){
                return $this->response('Data saved.', 200);
            }
        }
        return $this->response("Saving error", 500);
    }

    

}
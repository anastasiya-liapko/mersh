<?php
require_once 'ApiController.php';

class CallApi extends ApiController
{
    public $apiName = 'call';


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
     * http://ДОМЕН/api/call/ + параметры запроса name, phone
     * @return string
     */
    public function createAction()
    {
        $name = $this->requestParams['name'] ?? '';
        $phone = $this->requestParams['phone'] ?? '';
        if($name && $phone){
			
			qi("INSERT INTO calls (`name`, `phone`) VALUES (?, ?)", [$name, $phone]);
			
			$last_id = qInsertId();
			
            if($last_id != '0'){
                return $this->response('Data saved.', 200);
            }
        }
        return $this->response("Saving error", 500);
    }

    

}
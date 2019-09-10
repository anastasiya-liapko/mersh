<?php

require_once(__DIR__ .'/../admin/engine/sql.php');
define('itemInPage', 12);	//элементов на странице

$class = explode('/', trim($_SERVER['REQUEST_URI'],'/'));

if ($class[0] == 'api'){
	$apiClass = ucfirst($class[1]).'Api';
}

try {
	require_once($apiClass.'.php');
    $api = new $apiClass();
    echo $api->run();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}
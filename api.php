<?php

header('Content-Type: application/json');

array_shift($url);
$controller = 'App\\Controllers\\'. ucfirst($url[0]).'Controller';

array_shift($url);
$method = strtolower($_SERVER['REQUEST_METHOD']);

try {
    $response = call_user_func_array([new $controller, $method], $url);
    echo json_encode($response);
} catch (Exception $e) {
    $response = ['code'=>404,'message'=>'Rota não encontrada'];
    echo json_encode($response);
}

http_response_code($response['code']);
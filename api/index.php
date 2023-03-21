<?php

require_once(dirname(__FILE__) . '/inc/config.php');
require_once(dirname(__FILE__) . '/inc/database.php');
require_once(dirname(__FILE__) . '/inc/api_res.php');
require_once(dirname(__FILE__) . '/inc/api_logic.php');


$api_res = new api_response();

if(!$api_res->check_method($_SERVER['REQUEST_METHOD']))
{
    $api_res->api_request_error('Invalid request method.');
}

$api_res->set_method($_SERVER['REQUEST_METHOD']);

$params = null;
if($api_res->get_method() == 'GET') {
    $api_res->set_endpoint($_GET['ep']);
    $params = $_GET;
} else if($api_res->get_method() == 'POST') {
    $dp = json_decode(file_get_contents('php://input'), true);
    $api_res->set_endpoint($dp['ep']);
    $params = $dp;
}

$api_logic = new api_logic($api_res->get_endpoint(), $params);

if(!$api_logic->endpoint_exists()){
    $api_res->api_request_error('Endpoint Inexistente: ' . $api_res->get_endpoint());
}

$result = $api_logic->{$api_res->get_endpoint()}();
$api_res->add_to_data('data', $result);

$api_res->send_response();
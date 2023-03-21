<?php

class api_response
{

    private $data;
    private $available_methods = ['GET', 'POST'];
    

    public function __construct()
    {
        $this->data = [];
    }

    public function check_method($method)
    {
        return in_array($method, $this->available_methods);
    }

    public function get_method()
    {
        return $this->data['method'];
    }

    public function set_method($method)
    {
        $this->data['method'] = $method;
    }

    public function set_endpoint($ep) 
    {
        $this->data['ep'] = $ep;
    }
    public function get_endpoint() 
    {
        return $this->data['ep'];
    }

    public function add_to_data($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function api_request_error($mensage = '')
    {
        $data_error = [
            'status' => 'ERROR',
            'message' => $mensage
        ];
        $this->data['data'] = $data_error;
        $this->send_response();
    }

    public function send_api_status()
    {
        $this->data['status'] = 'SUCCESS';
        $this->data['message'] = 'API is Running!';
        $this->send_response();
    }

    public function send_response()
    {
        header("Content-Type:application/json");
        echo json_encode($this->data);
        die(1);
    }
}
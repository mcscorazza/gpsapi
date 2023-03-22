<?php

class api_logic
{

    private $ep;
    private $params;

    public function __construct($ep, $params = null)
    {
        $this->ep = $ep;
        $this->params = $params;
    }
    public function endpoint_exists()
    {
        return method_exists($this, $this->ep);
    }
    public function status()
    {
        return [
            'status' => 'SUCCESS',
            'message' => "API Running OK!"
        ];
    }
    public function error_response($message)
    {
        return [
            'status' => 'ERROR',
            'message' => $message,
            'result' => []
        ];
    }

    public function crgps()
    {
        $entries = $this->params;
        $db = new database();

        echo "Creating GPS Data <br><pre>";
        
        for($i = 0; $i < count($entries['data']); $i++){
            $params = [
                ':latitude' => $entries['data'][$i]['lt'],
                ':longitude' => $entries['data'][$i]['lg'],
                ':date' => $entries['data'][$i]['dt']
            ];
            
            $db->EXE_NON_QUERY("
            INSERT INTO ftGPS (latitude, longitude, date) VALUES (
                :latitude,
                :longitude,
                :date
            )", $params);
        } 

        return [
            'status' => 'SUCCESS',
            'message' => 'New Data Added.',
            'results' => []
        ];
    }


}
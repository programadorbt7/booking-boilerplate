<?php

namespace App\Http\Controllers\Web;

use Request2;
use HTTP_Request2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public $token;
    public $cookie;

    public function __construct()
    {   //Token de pruebas
        //$this->token = "Bearer 104|iA0ondbvYPhe24x4RxyOk3yXSwZ9fXSOghHESRMMaf1099b8";
        $this->token = "Bearer 104|iA0ondbvYPhe24x4RxyOk3yXSwZ9fXSOghHESRMMaf1099b8";
        $this->cookie = "XSRF-TOKEN=".uniqid('bt_');
    }

    public function token(){
        //Token de pruebas
        //return '104|iA0ondbvYPhe24x4RxyOk3yXSwZ9fXSOghHESRMMaf1099b8';
        return "104|iA0ondbvYPhe24x4RxyOk3yXSwZ9fXSOghHESRMMaf1099b8";
    }

    public function getContentGet($path, $data = null){     
        $request = new HTTP_Request2();
        $request->setUrl($path);
        $request->setMethod(HTTP_Request2::METHOD_GET);
 
        $request->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $request->setHeader(array(
            'Authorization' => $this->token,
            'Cookie' => $this->cookie,
            'Content-Type' => 'application/json'
        ));   

        if($data != null){
            $request->setBody(json_encode($data));
        }        
        
        try {
            $response = $request->send();   
            if ($response->getStatus() == 200 || $response->getStatus() == 201) {
                $respuesta =  (array) json_decode($response->getBody(), true);  
                return $respuesta;                 
            }else {
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                $response->getReasonPhrase();
            }
        }
        catch(HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }         
    }

}

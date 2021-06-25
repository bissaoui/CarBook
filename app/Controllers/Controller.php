<?php


namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;

class Controller {

    protected $container;

    public function __construct($container)
    {
        session_start();

        $this->container=$container;
    }

    public  function render(ResponseInterface $response,$file,$params=[]){

        $this->container->view->render($response,$file,$params);

    }
   
}
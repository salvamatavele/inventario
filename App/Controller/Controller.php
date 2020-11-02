<?php
namespace App\Controller;

use League\Plates\Engine;
/**
 * Controller que vai ser extendido
 * Com todas as propriedades de $view e $router
 * Controller
 */
class Controller
{
    /**
     * view
     *
     * @var [pretected $view]
     */
    protected $view;
    /**
     * router
     *
     * @var [$router]
     */
    protected $router;

    public function __construct($router, $dir = null, $global = [])
    {
        $dir = $dir ?? template();
        $this->view = Engine::create($dir,"php");
        $this->router = $router;

        $this->view->addData(["router"=> $this->router]);
        if ($global){
          $this->view->addData($global); 
        }

    }

}
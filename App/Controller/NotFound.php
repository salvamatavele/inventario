<?php
namespace App\Controller;

use App\Controller\Controller;

class NotFound extends Controller
{
  

    public function __construct($router)
    {
        parent::__construct($router);
    }
    /**
     * Index to error template
     */

    public function index(array $data)
    {
        # code...
        $title = 'Ooops...Error'.$data['errcode'];
        $error = $data['errcode'];
        echo $this->view->render('notFound',[
            'title'=>$title,
            'error'=>$error
        ]);
    }

    
}


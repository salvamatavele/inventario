<?php

namespace App\Controller\Admin;

use Resource\Authentication;
use App\Controller\Controller;
use App\Model\Category;
use App\Model\Location;
use App\Model\Post;
use App\Model\Product;
use App\Model\User;
use Resource\Paginate;

class AdminController extends Controller
{
    public function __construct($router, $dir = __DIR__ . "/../../../Source/template/admin/")
    {
        Authentication::isAdmin(['superadmin','admin']);
        parent::__construct($router, $dir);
    }

    public function index()
    {
        $id = $_SESSION['id'];
        $user = (new User())->findById($id)->data();


        $allUsers = (new User())->find()->count();
        $allLocations = (new Location)->find()->count();
        $allCategories = (new Category)->find()->count(); //(empty((new Category)->find()->fetch(true)) ) ? 0:count((new Category)->find()->fetch(true));
        $allProducts = (new Product)->find()->count();
        echo $this->view->render('home', [
            'title' => 'Admin Panel',
            'user'=>$user,
            'allUsers'=>$allUsers, 
            'allLocations'=>$allLocations, 
            'allCategories'=>$allCategories, 
            'allProducts'=>$allProducts        
        ]);
    }
    
}

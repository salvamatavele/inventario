<?php

namespace App\Controller\Post;

use Resource\Authentication;
use App\Controller\Controller;
use App\Model\Category;
use App\Model\Color;
use App\Model\Location;
use App\Model\Product;
use App\Model\User;
use Resource\Paginate;

class ProductController extends Controller
{
    public function __construct($router, $dir = __DIR__ . "/../../../Source/template/product/")
    {
        Authentication::isAuth();
        parent::__construct($router, $dir);
    }

    public function index()
    {
        $files = (new Product);
        $user = (new User)->findById($_SESSION['id']);
        $categories = (new Category)->find()->fetch(true);
        $locations = (new Location)->find()->fetch(true);
        $all = $files->find()->count();
        $paginate = new Paginate;
        $data = $paginate->paginate($files, 6, 3, "<i class='material-icons small'>keyboard_arrow_left</i>", "<i class='material-icons small'>keyboard_arrow_right</i>");

        echo $this->view->render('index', [
            'title' => 'Home',
            'posts' => $data,
            'user' => $user,
            'categories' => $categories,
            'cty' => new Category(),
            'lct' => new Location(),
            'clr' => new Color(),
            'locations' => $locations,
            'all' => $all,
            'paginate' => $paginate->paginator()
        ]);
    }
    public function category(array $data)
    {
        $files = (new Product);
        $user = (new User)->findById($_SESSION['id']);
        $categories = (new Category)->find()->fetch(true);
        $locations = (new Location)->find()->fetch(true);
        $params = http_build_query(["category_id"=>$data['id']]);
        $all = $files->find("category_id = :category_id",$params)->count();
        $paginate = new Paginate;
        $data = $paginate->paginate($files, 6, 3, "<i class='material-icons small'>keyboard_arrow_left</i>", "<i class='material-icons small'>keyboard_arrow_right</i>","category_id = :category_id",$params);
       
        echo $this->view->render('byCategory', [
            'title' => 'Product|Category',
            'posts' => $data,
            'user' => $user,
            'categories' => $categories,
            'cty' => new Category(),
            'lct' => new Location(),
            'clr' => new Color(),
            'locations' => $locations,
            'all' => $all,
            'paginate' => $paginate->paginator()
        ]);
    }

    public function location(array $data)
    {
        $files = (new Product);
        $user = (new User)->findById($_SESSION['id']);
        $categories = (new Category)->find()->fetch(true);
        $locations = (new Location)->find()->fetch(true);
        $params = http_build_query(["location_id"=>$data['id']]);
        $all = $files->find("location_id = :location_id",$params)->count();
        $paginate = new Paginate;
        $data = $paginate->paginate($files, 6, 3, "<i class='material-icons small'>keyboard_arrow_left</i>", "<i class='material-icons small'>keyboard_arrow_right</i>","location_id = :location_id",$params);
       
        echo $this->view->render('byLocation', [
            'title' => 'Product|Location',
            'posts' => $data,
            'user' => $user,
            'categories' => $categories,
            'cty' => new Category(),
            'lct' => new Location(),
            'clr' => new Color(),
            'locations' => $locations,
            'all' => $all,
            'paginate' => $paginate->paginator()
        ]);
    }

    public function search(array $data)
    {
        $params = http_build_query(["name" => '%' . $data['search'] . '%']);
        $files = (new Product)->find("LOWER(name) like LOWER(:name)", $params)->fetch(true);
        if (!$files) {
            echo "<h4 class='center'>Nenhum iten encontrado.</h4>";
        } else {
            foreach ($files as $post) {
                $category = (new Category)->findById($post->category_id);
                $location = (new Location)->findById($post->location_id);
                $color = (new Color)->findById($post->color_id);
                echo "
                <div class='col s12 m4'>
                <div class='card medium'>
                    <div class='card-image'>
                        <img class='materialboxed' data-caption='{$post->name}' src='".url($post->image)."'>
                    </div>
                    <div class='card-content'>
                        <span class='card-title activator grey-text text-darken-4'>{$post->name}<i class='material-icons right'>more_vert</i></span>
                        <p><a href='#'>Criado aos {$post->created_at}</a></p>
                    </div>
                    <div class='card-reveal'>
                        <span class='card-title grey-text text-darken-4'>{$post->name}<i class='material-icons right'>close</i></span>
                        <h6><strong class='blue-grey-text'>Quantidade</strong>: {$post->stock}</h6>
                        <h6><strong class='blue-grey-text'>Cor</strong>: {$color->name}</h6>
                        <h6><strong class='blue-grey-text'>Compartimento</strong>: {$location->name}</h6>
                        <h6><strong class='blue-grey-text'>Categoria</strong>: {$category->name}</h6>
                        <h6><strong class='blue-grey-text'>Estado de conservação</strong>: {$post->status}</h6>
                        <p class='grey-text'><strong class='blue-grey-text'>Descricao</strong>: {$post->description}</p>
                    </div>
                </div>
            </div>
                ";
            }
        }
    }
}

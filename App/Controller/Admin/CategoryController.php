<?php

namespace App\Controller\Admin;

use Resource\Paginate;
use App\Model\Category;
use Resource\Authentication;
use App\Controller\Controller;
use App\Model\User;
use Resource\Validator;

class CategoryController extends Controller
{

    public function __construct($router, $dir = __DIR__ . "/../../../Source/template/admin/category/")
    {
        Authentication::permition(['superadmin', 'admin']);
        parent::__construct($router, $dir);
    }

    public function index()
    {
        $data = (new Category());
        $user = (new User)->findById($_SESSION['id']);
        $paginate = new Paginate();

        $categories = $paginate->paginate($data, 5, 3, "<i class='material-icons small'>keyboard_arrow_left</i>", "<i class='material-icons small'>keyboard_arrow_right</i>");


        echo $this->view->render('index', [
            'categories' => $categories,
            'title' => 'Categories',
            'user'=>$user,
            'paginate' => $paginate->paginator()
        ]);
    }

    public function store(array $data)
    {
        $category = new Category();
        $validate = new Validator();
        $validate->validateFields(['category_name' => $data['name']], 'A categoria e de preenchimento obrigatório');
        $validate->isUnique($data['name'], $category, 'name', 'Essa categoria ja foi registada.');
        if (!empty($validate->getErrors())) {
            echo \json_encode(['errors' => $validate->getErrors()]);
            return;
        }

        $category->name = $data['name'];
        if (!$category->save()) {
            echo \json_encode(['errors' => 'Ooops...Nao foi possível registar a categoria! Tente novamente.']);
            return;
        }
        echo \json_encode(['success' => 'Categoria registada com sucesso.']);
        return;
    }

    public function edit(array $data)
    {
        $category = (new Category())->findById($data['id']);
        $response = ['id'=>$category->id,'name'=>$category->name];
        echo json_encode($response);
        return;
    }

    public function update(array $data)
    {
        $category = new Category();
        $validate = new Validator();
        $validate->validateFields(['category_name' => $data['name']], 'A categoria e de preenchimento obrigatório');
        $validate->isUnique($data['name'], $category, 'name', 'Essa categoria ja foi registada.');
        if (!empty($validate->getErrors())) {
            echo \json_encode(['errors' => $validate->getErrors()]);
            return;
        }
        $update = $category->findById($data['id']);
        $update->name = $data['name'];
        if (!$update->save()) {
            echo \json_encode(['errors' => 'Ooops...Nao foi possível atualizar a categoria! Tente novamente.']);
            return;
        }
        echo \json_encode(['success' => 'Categoria atualizada com sucesso.']);
        return;
    }

    public function destroy(array $data)
    {
        $category = (new Category())->findById($data['id']);
        if(!$category->destroy()){
            echo json_encode(['error'=>'Ooops...Falha ao tentar eliminar categoria'.$category->name]);
            return;
        }
        echo json_encode(['success'=>'Categoria eliminada com sucesso.']);
        return;
    }
}

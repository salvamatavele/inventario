<?php

namespace App\Controller\Admin;

use App\Model\Color;
use Resource\Paginate;
use Resource\Validator;
use Resource\Authentication;
use App\Controller\Controller;
use App\Model\User;

class ColorController  extends Controller
{
    public function __construct($router, $dir = __DIR__ . "/../../../Source/template/admin/color/")
    {
        Authentication::permition(['superadmin', 'admin']);
        parent::__construct($router, $dir);
    }

    public function index()
    {
        $data = (new Color());
        $user = (new User)->findById($_SESSION['id']);
        $paginate = new Paginate();

        $colores = $paginate->paginate($data, 5, 3, "<i class='material-icons small'>keyboard_arrow_left</i>", "<i class='material-icons small'>keyboard_arrow_right</i>");


        echo $this->view->render('index', [
            'colores' => $colores,
            'title' => 'Cores',
            'user'=>$user,
            'paginate' => $paginate->paginator()
        ]);
    }

    public function store(array $data)
    {
        $color = new Color();
        $validate = new Validator();
        $validate->validateFields(['color_name' => $data['name']], 'A cor e de preenchimento obrigatório');
        $validate->isUnique($data['name'], $color, 'name', 'Essa cor ja foi registada.');
        if (!empty($validate->getErrors())) {
            echo \json_encode(['errors' => $validate->getErrors()]);
            return;
        }

        $color->name = $data['name'];
        if (!$color->save()) {
            echo \json_encode(['errors' => 'Ooops...Nao foi possível registar a cor! Tente novamente.']);
            return;
        }
        echo \json_encode(['success' => 'Cor registada com sucesso.']);
        return;
    }

    public function edit(array $data)
    {
        $color = (new Color())->findById($data['id']);
        $response = ['id'=>$color->id,'name'=>$color->name];
        echo json_encode($response);
        return;
    }

    public function update(array $data)
    {
        $color = new Color();
        $validate = new Validator();
        $validate->validateFields(['color_name' => $data['name']], 'A cor e de preenchimento obrigatório');
        $validate->isUnique($data['name'], $color, 'name', 'Essa cor ja foi registada.');
        if (!empty($validate->getErrors())) {
            echo \json_encode(['errors' => $validate->getErrors()]);
            return;
        }
        $update = $color->findById($data['id']);
        $update->name = $data['name'];
        if (!$update->save()) {
            echo \json_encode(['errors' => 'Ooops...Nao foi possível atualizar a cor! Tente novamente.']);
            return;
        }
        echo \json_encode(['success' => 'Cor atualizada com sucesso.']);
        return;
    }

    public function destroy(array $data)
    {
        $color = (new Color())->findById($data['id']);
        if(!$color->destroy()){
            echo json_encode(['error'=>'Ooops...Falha ao tentar eliminar cor'.$color->name]);
            return;
        }
        echo json_encode(['success'=>'Cor eliminada com sucesso.']);
        return;
    }
}

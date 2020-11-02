<?php

namespace App\Controller\Admin;

use App\Model\User;
use Resource\Paginate;
use App\Model\Location;
use Resource\Validator;
use Resource\Authentication;
use App\Controller\Controller;

class LocationContoller extends Controller
{
    public function __construct($router, $dir = __DIR__ . "/../../../Source/template/admin/location/")
    {
        Authentication::permition(['superadmin', 'admin']);
        parent::__construct($router, $dir);
    }

    public function index()
    {
        $data = new Location();
        $user = (new User)->findById($_SESSION['id']);
        $paginate = new Paginate();

        $locations = $paginate->paginate($data, 5, 3, "<i class='material-icons small'>keyboard_arrow_left</i>", "<i class='material-icons small'>keyboard_arrow_right</i>");


        echo $this->view->render('index', [
            'locations' => $locations,
            'title' => 'Localizacoes',
            'user'=>$user,
            'paginate' => $paginate->paginator()
        ]);
    }

    public function store(array $data)
    {
        $location = new Location();
        $validate = new Validator();
        $validate->validateFields(['location' => $data['name']], 'O nome do compartimento e de preechimeto obrigatorio');
        $validate->isUnique($data['name'], $location, 'name', 'O Compartimento ja foi registado.');
        if (!empty($validate->getErrors())) {
            echo \json_encode(['errors' => $validate->getErrors()]);
            return;
        }

        $location->name = $data['name'];
        if (!$location->save()) {
            echo \json_encode(['errors' => 'Ooops...Nao foi possivel registar a Compartimento! Tente novamente.']);
            return;
        }
        echo \json_encode(['success' => 'Compartimento registado com sucesso.']);
        return;
    }

    public function edit(array $data)
    {
        $location = (new Location())->findById($data['id']);
        $response = ['id'=>$location->id,'name'=>$location->name];
        echo json_encode($response);
        return;
    }

    public function update(array $data)
    {
        $location = new Location();
        $validate = new Validator();
        $validate->validateFields(['loca$location_name' => $data['name']], 'A Compartimento e de preechimeto obrigatorio');
        $validate->isUnique($data['name'], $location, 'name', 'O Compartimento ja foi registado.');
        if (!empty($validate->getErrors())) {
            echo \json_encode(['errors' => $validate->getErrors()]);
            return;
        }
        $update = $location->findById($data['id']);
        $update->name = $data['name'];
        if (!$update->save()) {
            echo \json_encode(['errors' => 'Ooops...Nao foi possível atualizar o Compartimento! Tente novamente.']);
            return;
        }
        echo \json_encode(['success' => 'Compartimento atualizado com sucesso.']);
        return;
    }

    public function destroy(array $data)
    {
        $location = (new Location())->findById($data['id']);
        if(!$location->destroy()){
            echo json_encode(['error'=>'Ooops...Falha ao tentar eliminar Compartimento'.$location->name]);
            return;
        }
        echo json_encode(['success'=>'Compartimento eliminado com sucesso.']);
        return;
    }

}

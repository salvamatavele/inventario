<?php

namespace App\Controller\Admin;

use App\Model\User;
use Resource\Paginate;
use App\Model\Category;
use App\Model\Location;
use Resource\Validator;
use Resource\FileManager;
use Resource\Authentication;
use App\Controller\Controller;


class PerfilController extends Controller
{
    public function __construct($router, $dir = __DIR__ . "/../../../Source/template/perfil/")
    {
        Authentication::isAuth();
        parent::__construct($router, $dir);
    }

    public function index()
    {
        $user = (new User)->findById($_SESSION['id']);
        $categories = (new Category)->find()->fetch(true);
        $locations = (new Location)->find()->fetch(true);
       
        echo $this->view->render('index', [
            'title' => $user->name,
            'categories' => $categories,
            'locations' => $locations,
            'user' => $user
        ]);
    }
    public function show(array $data)
    {
        $id = $data['id'];
        $user = new User();
        $response = $user->findById($id)->data();
        echo  \json_encode($response);

        return;
    }

    public function store(array $data)
    {
        $user = new User();

        $validate = new Validator;
        $validate->validateFields($data);
        $validate->isUnique($data['email'], (new User), 'email');
        $validate->isValidConfirmPasswd($data['password'], $data['confirmPassword']);
        $validate->isStrongPassword($data['password']);

        if (!empty($validate->getErrors())) {
            # code...
            $error = $validate->getErrors();
            echo json_encode(['errors' => $error]);
            return;
        } else {
            $avatar = make_avatar($data['name']);
            $picture = null;
            $image = $picture ?? $avatar;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->permition = $data['permition'];
            $user->image = $image;
            $user->password = \passwordHash($data['password']);
            
            if (!$user->save()) {
                (new FileManager())->deleteFiles($image);
                echo json_encode(['error' => 'Ooops...Falha ao tentar registar o usuario. Por favor tente novamente.']);
                return;
            }

            echo json_encode(['success' => 'Usuario cadastrado com sucesso.']);
            return;
        }
    }
    public function edit(array $data)
    {
        $id = $data['id'];
        $user = new User();
        $response = $user->findById($id)->data();

        echo  \json_encode($response);

        return;
    }

    public function update(array $data)
    {
        $user = (new User)->findById($data['id']);

        $validate = new Validator;
        $validate->validateFields($data);
        $validate->isUniqueEdit($data['id'],$data['email'], (new User), 'email');
        if (!empty($validate->getErrors())) {
            # code...
            $error = $validate->getErrors();
            echo json_encode(['errors' => $error]);
            return;
        }else {
            (new FileManager())->deleteFiles( $user->image );
            $avatar = make_avatar($data['name']);
            $picture = null;
            $image = $picture ?? $avatar;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->permition = $data['permition'];
            $user->image = $image;
            $user->save();
            if (!$user) {
                echo json_encode(['error' => 'Ooops...Falha ao tentar atualizar o usuario. Por favor tente novamente.']);
                return;
            }

            echo json_encode(['success' => 'Usuario atualizado com sucesso.']);
            return;
        }

    }

    public function destroy(array $data)
    {
        $user = (new User())->findById($data['id']);
        (new FileManager())->deleteFiles( $user->image );
        if($user->destroy()){
            echo json_encode(['success'=>'Usuário eliminado com sucesso.']);
        }else{
            echo json_encode(['error'=>'Falha ao tentar eliminar usuário '.$user->name]);
        }
        
    }

    public function profile()
    {
        $user = (new User())->findById($_SESSION['id']);
        echo $this->view->render('profile',[
            'title'=>'My Profile->'.$user->name
        ]);
    }
}

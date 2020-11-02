<?php

namespace App\Controller\Admin;

use App\Model\User;
use Resource\Paginate;
use Resource\Validator;
use Resource\FileManager;
use Resource\Authentication;
use App\Controller\Controller;
use App\Model\Category;

class UserController extends Controller
{
    public function __construct($router, $dir = __DIR__ . "/../../../Source/template/admin/user/")
    {
        Authentication::permition(['superadmin', 'admin', 'normal']);
        parent::__construct($router, $dir);
    }

    public function index()
    {
        $users = (new User);
        $user = (new User)->findById($_SESSION['id']);
        $paginate = new Paginate;
        $params = http_build_query(["id" => $_SESSION['id'], 'permition' => 'superadmin']);
        $data = $paginate->paginate($users, 5, 3, "<i class='material-icons small'>keyboard_arrow_left</i>", "<i class='material-icons small'>keyboard_arrow_right</i>","id != :id and permition != :permition", $params);
        echo $this->view->render('index', [
            'title' => 'Users',
            'user' => $user,
            'users' => $data,
            'paginate' => $paginate->paginator()
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
        $validate->isUniqueEdit($data['id'], $data['email'], (new User), 'email');
        if (!empty($validate->getErrors())) {
            # code...
            $error = $validate->getErrors();
            echo json_encode(['errors' => $error]);
            return;
        } else {
            (new FileManager())->deleteFiles($user->image);
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
        if ($user->destroy()) {
            (new FileManager())->deleteFiles($user->image);
            echo json_encode(['success' => 'Usuário eliminado com sucesso.'], 200);
        } else {
            echo json_encode(['error' => 'Falha ao tentar eliminar usuário ' . $user->name]);
        }
    }

    public function profile()
    {
        $user = (new User())->findById($_SESSION['id']);
        echo $this->view->render('profile', [
            'title' => $user->name,
            'user' => $user
        ]);
    }

    public function upload(array $data)
    {
        $upload = new FileManager();
        $user = (new User)->findById($_SESSION['id']);
        $photo = $user->image;
        $uploaded = $upload->uploadSingleImage($data, 'Public/storage', 1920);
        if ($uploaded) {
            $image = $upload->getUploadedPath();

            $user->image = $image;
            $insert = $user->save();
            if ($insert) {
                $upload->deleteFiles($photo);
                echo json_encode(['success' => 'Imagem atualizada com sucesso.']);
                return;
            } else {
                $upload->deleteFiles($image);
                echo json_encode(['error' => ['Ooops...Nao foi possivel atualizar a imagem']]);
                return;
            }
        } else {
            $error = $upload->getError();
            echo json_encode(['error' => $error]);
            return;
        }
    }

    public function updatePerfil(array $data)
    {
        $id = $_SESSION['id'];
        $user = new User();
        $validate = new Validator();
        $validate->validateFields($data);
        $validate->isValidEmail($data['email']);
        $validate->isUniqueEdit($id, $data['email'], $user, 'email');
        if (!empty($validate->getErrors())) {
            echo json_encode(['error' => $validate->getErrors()], 400);
            return;
        } else {
            $update = $user->findById($id);
            $update->name = $data['name'];
            $update->email = $data['email'];
            if ($update->save()) {
                echo json_encode(['success' => 'Perfil atualizado com sucesso'], 201);
                return;
            } else {
                echo json_encode(['error' => ['Ooops...Nao foi possivel atualizar a conta. Tente novamente']], 400);
                return;
            }
        }
    }
    public function password(array $data)
    {
        $user = new User();
        $validate = new Validator();
        $validate->validateFields($data);
        $validate->isStrongPassword($data['new_password'],1,"The password is not strong (4 chars), may contain at least number and character.");
        $validate->isValidConfirmPasswd($data['new_password'],$data['confirmPassword'],"A senha de confirmacao e diferente da nova senha");
        if (!empty($validate->getErrors())) {
            echo json_encode(['error' => $validate->getErrors()], 400);
            return;
        } else {
            $validPassword = $validate->isValidPassword($_SESSION['id'], $user, 'id', $data['last_password']);
            if ($validPassword) {
                $update = $user->findById($_SESSION['id']);
                $update->password = passwordHash($data['new_password']);
                if ($update->save()) {
                    echo json_encode(['success' => 'Senha atualizada com sucesso'], 201);
                return;
                }else{
                    echo json_encode(['error' => ['Ooops...Nao foi possivel atualizar a senha. Tente novamente']], 400);
                return;
                }

            } else {
                echo json_encode(['error' => ['Senha anterior incorreta.']], 400);
                return;
            }
        }
    }
}

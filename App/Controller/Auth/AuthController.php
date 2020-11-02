<?php

namespace App\Controller\Auth;

use App\Model\User;
use Resource\Email;
use Resource\Sessions;
use Resource\Validator;
use Resource\FileManager;
use App\Model\PasswordReset;
use Resource\Authentication;
use App\Controller\Controller;

class AuthController extends Controller
{

    public function __construct($router, $dir = __DIR__ . "/../../../Source/template/auth/")
    {
        session_start();
        parent::__construct($router, $dir);
    }

    public function index(array $data)
    {
        # code...
        $title = 'Login';
        echo $this->view->render('login-register', [
            'title' => $title
        ]);
    }

    public function create(array $data)
    {
        $user = new User();


        $validate = new Validator;
        $validate->validateFields($data);
        $validate->isUnique($data['email'], (new User), 'email');
        $validate->isValidConfirmPasswd($data['password'], $data['confirmPassword']);
        $validate->isStrongPassword($data['password'], 2, 'The password may contain at least 6 Chartere( Uppercase, Lowercase, number and symbol.)');
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
            $user->image = $image;
            $user->password = \passwordHash($data['password']);
            $save = $user->save();
            if (!$save) {
                (new FileManager)->deleteFiles($image);
                echo json_encode(['error' => 'Ooops...Falha ao tentar registar o usuario. Por favor tente novamente.']);
                return;
            } else {

                echo json_encode(['success' => 'Usuario cadastrado com sucesso.']);
                return;
            }
        }
    }

    public function validation(array $data)
    {
        $user = new User();
        $validate = new Validator();
        $validate->validateFields($data);
        $validate->isValidEmail($data['user-email']);
        if (!empty($validate->getErrors())) {
            # code...
            $error = $validate->getErrors();
            echo json_encode(['errors' => $error]);
            return;
        } else {
            $checkEmail = $validate->isExist($data['user-email'], (new User), 'email');
            if (!$checkEmail) {
                echo json_encode(['error' => 'Email ou senha invalida']);
                return;
            }

            $checkPasswd = $validate->isValidPassword($data['user-email'], (new User), 'email', $data['passwd']);
            if (!$checkPasswd) {
                echo json_encode(['error' => 'Email ou senha invalida']);
                return;
            }
            $auth = new Sessions;
            $dados = $auth->auth($data['user-email'], (new User), 'email');
            $ss = $auth->setSession($dados);
            echo json_encode(['success' => $ss]);
            return;
        }
    }
    /**
     * send password reset email
     *
     * @param array $data
     * @return void
     */
    public function sendPassword(array $data)
    {
        $validate = new Validator();
        $validate->validateFields($data);
        $validate->isValidEmail($data['email']);
        $email = $validate->isExist($data['email'], (new User), "email");
        if (!empty($validate->getErrors())) {
            echo json_encode(["error" => $validate->getErrors()]);
            return;
        }
        if ($email) {
            $password = new PasswordReset();
            $password->email = $data['email'];
            $password->token = _token();
            if ($password->save()) {
                $mail = new Email();
                $mail->add(
                    "Recuperação de senha da UMUM Inventario",
                    "<h2>OLA. Clique no botão abaixo para recuperar a sua senha. Valido por 20 minutos.</h2><a style='color: white; background-color: #5A827F; padding: 5px 11px; border: 2px solid #5a827f;' href='" . $this->router->route('reset', ['token' => $password->token]) . "'>Eu quero recuperar a senha.</a>",
                    "",
                    $data['email']
                )->send();
                if (!$mail->getError()) {
                    $_SESSION['token'] = $password->token;
                    echo json_encode(['success' => 'Foi enviado um email de recuperação de  senha para sua conta']);
                    return;
                } else {
                    echo json_encode(['error' => $mail->getError()->getMessage()]);
                    return;
                }
            } else {
                echo json_encode(['error' => 'Ooops...Nao foi possivel afectuar essa operacao. Por favor tenete mais tarde.']);
                return;
            }
        } else {
            echo json_encode(['error' => 'Nao existe conta com esse email']);
            return;
        }
    }

    public function reset(array $data)
    {
        echo $this->view->render("reset_password", [
            'title' => 'Reset Password'
        ]);
    }

    public function storeNewPassword(array $data)
    {
        $token = (isset($_SESSION['token'])) ? $_SESSION['token']:null ;
        if (isset($token)) {
            $param = http_build_query(["token" => $token]);
            $email = (new PasswordReset)->find("token = :token", $param)->fetch();
            $isEmail = $email->email;
            if (isset($isEmail)) {
                $validate = new Validator();
                $validate->validateFields($data);
                $validate->isStrongPassword($data['password'], 1, "The password is not strong (4 chars), may contain at least number and character.");
                $validate->isValidConfirmPasswd($data['password'], $data['confirmPassword'], "A senha de confirmacao e diferente da nova senha");
                $existEmail = $validate->isExist($isEmail, (new User), "email");
                if ($existEmail) {
                    if (!empty($validate->getErrors())) {
                        echo json_encode(["error" => $validate->getErrors()]);
                        return;
                    }
                    $acout = http_build_query(["email" => $isEmail]);
                    $id = (new User)->find("email = :email", $acout)->fetch();

                    $update = (new User)->findById($id->id);
                    $update->password = passwordHash($data['password']);
                    if ($update->save()) {
                        echo json_encode(['success' => 'A sua nova senha foi configurada com sucesso. Faça o login novamente com a sua nova senha.'], 201);
                        return;
                    } else {
                        echo json_encode(['error' => ['Ooops...Nao foi possível recuperar a sua senha. Tente novamente']], 400);
                        return;
                    }
                } else {
                    echo json_encode(['error' => 'Ja nao existe conta com esse email']);
                    return;
                }
            } else {
                echo json_encode(['error' => ['Sem permissão para fazer essa operação. Use o botão de recuperação de senha do email que lhe foi enviado ou faça outra requisição.']]);
                return;
            }
        } else {
            echo json_encode(['error' => ['O seu pedido de recuperação de senha expirou. Por favor tente novamente.']]);
            return;
        }
    }


    /**
     * Logout 
     *
     * @param array $data
     * @return void
     */
    public function logout()
    {
        Authentication::logout();
    }
}

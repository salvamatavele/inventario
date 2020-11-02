<?php
namespace App\Controller;

use App\Controller\Controller;
use Resource\Authentication;
use Resource\Email;


class HomeController extends Controller {
	public function __construct($router) {
		Authentication::guest();

		parent::__construct($router);
	}

	public function index(array $data) {

		echo $this->view->render('home');
	}
	public function contact(array $data) {
		$mail = new Email();
		$mail->add(
			"Ola mundo esse meu send de attachment com PhpMailer",
			"<h2>Estou apenas testando</h2>Sera que fncionou?",
			"root toor",
			"smatavele1@gmail.com"
		)->attach("Public/storage/images/2020/10/13892167-492801577582942-1202031351880158042-n.jpg", "root")->send();
		if (!$mail->getError()) {
			var_dump(true);
		} else {
			echo $mail->getError();
		}
	}

}

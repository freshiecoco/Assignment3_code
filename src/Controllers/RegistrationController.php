<?php

namespace src\Controllers;

use core\Request;
use core\helpers;
use PDOException;
use src\Repositories\UserRepository;

class RegistrationController extends Controller {

	/**
	 * @return void
	 */
	public function index(): void {
		$this->render('register');
	}

	/**
	 * @param Request $request
	 * @return void
	 */
	public function register(Request $request): void {
		$name = $request->input('username');
		$email= $request->input('email');
		$password = $request->input('password');
		
		if(!isValidRegistration($name, $email, $password)) {
			$this->redirect('/register');
		} 
		$passwordDigest = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
		$userRepository = new UserRepository();
		$userRepository->saveUser($name, $email, $passwordDigest);
		$this->redirect('/login');
	}

}

<?php

namespace src\Controllers;

use core\Request as Request;
use Hybridauth\Exception\InvalidArgumentException;
use Hybridauth\Exception\UnexpectedValueException;
use src\Repositories\UserRepository as UserRepository;

require_once __DIR__ . '/../../vendor/hybridauth/hybridauth/src/autoload.php'; 
use Hybridauth\Hybridauth;

class LoginController extends Controller {
	/**
	 * Show the login page.
	 * @return void
	 */
	public function index(): void {
		$this->render('login');
	}

	/**
	 * Process the login attempt.
	 * @param Request $request
	 * @return void
	 */
	public function login(Request $request): void {
		$email= $request->input('email');
		$userRepository = new UserRepository();
		$user = $userRepository->getUserByEmail($email);
		if(!$user) {
			$_SESSION['login_error'] = "Wrong email or password. Please try again.";
			$this->redirect('/login');
		}
		
		$hash     = $user->password_digest;
		$userId   = $user->id;
		$userName = $user->name;
		$userPic  = $user->profile_picture;
		if (password_verify($request->input('password'), $hash)) {
			$this->setSessionData('user_id', $userId);
			$this->setSessionData('user_name', $userName);
			$this->setSessionData('user_pic', $userPic);
			$this->redirect('/');
		} else {
			$_SESSION['login_error'] = "Wrong password. Please try again.";
			$this->redirect('/login');
		}
	}

    /**
     * @throws UnexpectedValueException
     * @throws InvalidArgumentException
     */
    public function loginWithGithub(): void {
        $config = require_once __DIR__ . '/../../config.php';
		$hybridauth = new Hybridauth($config);
		$adapter = $hybridauth->authenticate('GitHub');
		$userInfoGithub = $adapter->getUserProfile();
		$githubEmail = $userInfoGithub->email;
		
		//check if user already exists in the database
		$userRepository = new UserRepository();
		$user = $userRepository->getUserByEmail($githubEmail);
		// if not, create a new entry in your "users" table using the GitHub details 
		if(!$user) {
			$githubName = $userInfoGithub->displayName;
			$newUser = $userRepository->saveUser($githubName, $githubEmail, '');
			// and log them in with the newly generated user ID
			$userId   = $newUser->id;
			$userName = $githubName;
			$userPic  = $newUser->profile_picture;
		} else { // If the user exists, log them in and establish a session.
			$userId   = $user->id;
			$userName = $user->name;
			$userPic  = $user->profile_picture;
		}
		$this->setSessionData('user_id', $userId);
		$this->setSessionData('user_name', $userName);
		$this->setSessionData('user_pic', $userPic);
		$this->setSessionData('loginWithGithub', 'true');

		$adapter->disconnect();
		$this->redirect('/');
	}

}

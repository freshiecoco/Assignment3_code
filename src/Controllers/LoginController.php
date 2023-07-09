<?php

namespace src\Controllers;

use core\Request as Request;
use Hybridauth\Exception\InvalidArgumentException;
use Hybridauth\Exception\UnexpectedValueException;
use src\Repositories\UserRepository as UserRepository;

require_once __DIR__ . '/../../vendor/hybridauth/hybridauth/src/autoload.php'; 
use Hybridauth\Hybridauth;

class LoginController extends Controller
{
	/**
	 * Show the login page.
	 * @return void
	 */
	public function index(): void
    {
		$this->render('login');
	}

	/**
	 * Process the login attempt.
	 * @param Request $request
	 * @return void
	 */
    public function login(Request $request): void
    {
        $email= $request->input("email");
        $userRepository = new UserRepository();
        $user = $userRepository->getUserByEmail($email);
        if (!$user)
        {
            $_SESSION['login_error'] = "Account does not exist!";
            $this->redirect("/login");
        }

        if (password_verify($request->input("password"), $user->password_digest))
        {
            $this->setUserSession($user->id, $user->name, $user->profile_picture);
            $this->redirect("/");
        }
        else
        {
            $_SESSION['login_error'] = "Password is incorrect!";
            $this->redirect("/login");
        }
    }

    /**
     * @throws UnexpectedValueException
     * @throws InvalidArgumentException
     */
    public function loginWithGithub(): void
    {
        $config = require_once __DIR__ . '/../../config.php';
		$hybridauth = new Hybridauth($config);
		$adapter = $hybridauth->authenticate('GitHub');
		$userInfoGithub = $adapter->getUserProfile();
		$userRepository = new UserRepository();
		$user = $userRepository->getUserByGithubId($userInfoGithub->identifier);

		if (!$user)
        {
			$user = $userRepository->saveUserGithub($userInfoGithub);
		}

		$this->setUserSession($user->id, $user->name, $user->profile_picture);
		$this->setSessionData('loginWithGithub', 'true');
		$adapter->disconnect();
		$this->redirect('/');
	}

    private function setUserSession(string $id, string $name, string $pic): void
    {
        $this->setSessionData('user_id', $id);
        $this->setSessionData('user_name', $name);
        $this->setSessionData('user_pic', $pic);
    }
}

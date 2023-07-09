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
    public function login(Request $request): void
    {
        $email= $request->input("email");
        $userRepository = new UserRepository();
        $user = $userRepository->getUserByEmail($email);
        if (!$user)
        {
            $this->redirect("/login");
        }

        $hash = $user->password_digest;
        $id = $user->id;
        $name = $user->name;
        $profile_picture = $user->profile_picture;
        if (password_verify($request->input("password"), $hash))
        {
            $this->setSessionData("user_id", $id);
            $this->setSessionData("user_name", $name);
            $this->setSessionData("user_pic", $profile_picture);
            $this->redirect("/");
        }
        else
        {
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

        // DEBUG START
        $this->setSessionData("github_info", $userInfoGithub->toString());
        // DEBUG END

		//check if user already exists in the database
		$userRepository = new UserRepository();
		$user = $userRepository->getUserByGithubId($userInfoGithub->identifier);
		// if not, create a new entry in your "users" table using the GitHub details 
		if (!$user)
        {
			$user = $userRepository->saveUserGithub($userInfoGithub);
		}

		$this->setSessionData('user_id', $user->id);
		$this->setSessionData('user_name', $user->name);
		$this->setSessionData('user_pic', $user->profile_picture);
		$this->setSessionData('loginWithGithub', 'true');

		$adapter->disconnect();
		$this->redirect('/');
	}
}

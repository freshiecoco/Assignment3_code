<?php

namespace src\Controllers;

use core\Request as Request;

require_once __DIR__ . '/../../vendor/hybridauth/hybridauth/src/autoload.php'; 
use Hybridauth\Hybridauth;

class LogoutController extends Controller {

	/**
	 * @return void
	 */
	public function logout(): void {
		session_unset();
		$this->destroySession();
		$this->redirect('/');
	}

}
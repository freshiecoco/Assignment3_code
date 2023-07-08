<?php

namespace src\Controllers;

use core\Request;
use src\Repositories\UserRepository;

class SettingsController extends Controller {

	/**
	 * Render the settings page.
	 *
	 * @param Request $request
	 * @return void
	 */
	public function index(Request $request): void {
		$userId = $request->input("userId");
		if(isset($userId)) {
			$userRepository = new UserRepository();
			$user = $userRepository->getUserById($userId);
			$this->render('settings', [$user]);
		} else {
			$this->render('settings');
		}
	}

	/**
	 * Process the request to update user data.
	 *
	 * @param Request $request
	 * @return void
	 */
	public function update(Request $request): void {
		// retrieve the uploaded file
		if(isset($_FILES['filename'])) {
			// retrieve uploaded Image
			$uploadedFile = $_FILES['filename'];
			$imageName = $uploadedFile['name'];
			$temporaryPath = $uploadedFile['tmp_name'];
			//move image to a permanent location - the public folder
			move_uploaded_file($temporaryPath, __DIR__ . "/../../public/images/$imageName");
			$_SESSION['user_pic'] = $imageName;
			if(empty($imageName)) {
				$imageName = "default.jpg";
				$_SESSION['user_pic'] = "default.jpg";
			}
		}
		$userId = $request->input('user_id');
		$userName = $request->input('updated_username');
		if(empty($userName)) {
			$_SESSION['username_error'] = "A username is required.";
		}
		else {
			$userRepository = new UserRepository();
			$userRepository->updateUser($userId, $userName, $imageName);
			$_SESSION['user_name'] = $userName;
		}
		$this->redirect("/settings?userId=$userId");
	}

}

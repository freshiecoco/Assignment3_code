<?php

function image(string $filename): string {
	return "/images/$filename";
}

function isValidEmail(string $email): bool {
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}
// password is > 8 characters and contains at least one symbol
function isValidPassword(string $password): bool {
	return (strlen($password) >= 8) && preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);
}

// we will need to check for a valid URL on the new_article and update_article pages.
function isValidUrl(string $url): bool {
	return filter_var($url, FILTER_VALIDATE_URL);
}

// for flash messages
function isValidContent(string $title, string $url): bool {
	$valid = true;
	if(empty($title)) {
		$valid = false;
		$_SESSION['title_error'] = "A title is required.";
	}
	if(empty($url)) {
		$valid = false;
		$_SESSION['url_error'] = "A Url is required.";
	} elseif (!isValidUrl($url)) {
		$valid = false;
		$_SESSION['url_error'] = "Please enter a valid url!";
	}
	return $valid;
}

function isValidRegistration(string $name, string $email, string $password): bool {
	$valid = true;
	if(empty($name)) {
		$valid = false;
		$_SESSION['name_error'] = "A name is required.";
	}
	if(!isValidEmail($email)) {
		$valid = false;
		$_SESSION['email_error'] = "A valid email is required";
	} 
	if (!isValidPassword($password)) {
		$valid = false;
		$_SESSION['password_error'] = "Password must at least 8 characters and contains a symbol!";
	}
	return $valid;
}
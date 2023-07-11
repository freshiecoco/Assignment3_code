<?php

use core\Router;

use src\Controllers\ArticleController;
use src\Controllers\LoginController;
use src\Controllers\LogoutController;
use src\Controllers\RegistrationController;
use src\Controllers\SettingsController;



Router::get('/', [ArticleController::class, 'index']); // the root/index page

// User/Auth related

Router::get('/login', [LoginController::class, 'index']);
Router::post('/login', [LoginController::class, 'login']);
Router::get('/login/github/callback', [LoginController::class, 'loginWithGithubGet']);
Router::post('/login/github', [LoginController::class, 'loginWithGithubPost']);

Router::get('/register', [RegistrationController::class, 'index']); // show registration form.
Router::post('/register', [RegistrationController::class, 'register']); // process a registration req.

Router::post('/logout', [LogoutController::class, 'logout']);

// Article related
Router::get('/new', [ArticleController::class, 'create']); // show new_article form
Router::post('/new', [ArticleController::class, 'store']); // store new_article in DB
Router::get('/update', [ArticleController::class, 'edit']); // show update_article in DB
Router::post('/update', [ArticleController::class, 'update']); // update the article in DB
Router::get('/delete', [ArticleController::class, 'delete']); // delete the article in DB

//Settings related
Router::get('/settings', [SettingsController::class, 'index']); // show user profile
Router::post('/settings', [SettingsController::class, 'update']); // update user profile

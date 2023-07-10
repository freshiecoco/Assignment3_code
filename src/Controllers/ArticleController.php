<?php

namespace src\Controllers;

use core\Request as Request;
use src\Repositories\ArticleRepository as ArticleRepository;
use src\Repositories\UserRepository as UserRepository;
use core\helpers;

class ArticleController extends Controller {

	/**
	 * Display the page showing the articles.
	 *
	 * @return void
	 */
	public function index(): void {
		$articleRepository = new ArticleRepository();
		$articles = $articleRepository->getAllArticles();
		$userRepository = new UserRepository();

		foreach($articles as $article) {
			$user = $userRepository->getUserById($article->author_id);
			$article->author_name = $user->name;
			$article->profile_pic = $user->profile_picture;
		}
		$this->render('index', $articles);
	}

    /**
     * Process the storing of a new article.
     *
     * @param Request $request
     * @return void
     */
	public function create(Request $request): void {
		//show users what is in DB
		$complete = $request->input('complete');
		if(isset($complete) && $complete == 'true') {
			if(isset($_SESSION['new_title'])) {
				$_SESSION['new_title'] = '';
			}
			if(isset($_SESSION['new_url'])) {
				$_SESSION['new_url'] = '';
			}
		}
		$this->render('new_article');
	}

	/**
	 * Save an article to the database.
	 *
	 * @param Request $request
	 * @return void
	 */
	public function store(Request $request): void {
		$title = $request->input('new_title');
		$url = $request->input('new_url');
		
		//flash message
		$valid = isValidContent($title, $url);
		//show the wrong input
		if(!$valid) {
			$_SESSION['new_title'] = $title;
			$_SESSION['new_url'] = $url;
			$this->redirect("/new" . '?complete=false');
		}

		$authorId = $request->input('author_id');
		$articleRepository = new ArticleRepository();
		$articles = $articleRepository->saveArticle($title, $url, $authorId);
		$this->redirect('/');
	}

	/**
	 * Show the form for editing an article.
	 *
	 * @param Request $request
	 * @return void
	 */
	public function edit(Request $request): void {
		$articleId = $request->input('id');
		$articleRepository = new ArticleRepository();
		$article   = $articleRepository->getArticleById($articleId);

		//show users what is in DB
		$updated = $request->input('updated');
		if(isset($updated) && $updated == 'true') {
			if(isset($_SESSION['updated_title' . $articleId])) {
				$_SESSION['updated_title' . $articleId] = $article->title;
			}
			if(isset($_SESSION['updated_url' . $articleId])) {
				$_SESSION['updated_url' . $articleId] = $article->url;
			}
		}
		
		$this->render('update_article', [$article]);
	}

	/**
	 * Process the editing of an article.
	 *
	 * @param Request $request
	 * @return void
	 */
	public function update(Request $request): void {
		$title = $request->input('updated_title');
		$url = $request->input('updated_url');
		$articleId = $request->input('id');

		//flash message
		$valid = isValidContent($title, $url);
		//show users their wrong input
		if(!$valid) {
			$_SESSION['updated_title' . $articleId] = $title;
			$_SESSION['updated_url' . $articleId]   = $url;
			$this->redirect('/update?id=' . urlencode($articleId) . '&updated=false');
		}
		$articleRepository = new ArticleRepository();
		$articleRepository->updateArticle(intval($articleId), $title, $url);
		$this->redirect('/');
	}

	/**
	 * Process the deleting of an article.
	 *
	 * @param Request $request
	 * @return void
	 */
	public function delete(Request $request): void {
		$articleId = $request->input('id');
		$articleRepository = new ArticleRepository();
		$articleRepository->deleteArticleById(intval($articleId));
		$this->redirect('/');
	}
}
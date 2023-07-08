<?php

namespace core;

class Request {

	private array $input = [];

	public function __construct() {
		foreach ($this->isHttpPost() ? $_POST : $_GET as $key => $value) {
			$this->input[$key] = $value;
		}
	}

	/**
	 * @return string The HTTP request method. eg. "post", "get", etc.
	 */
	public function method(): string {
		return $_SERVER['REQUEST_METHOD'];
	}

	public function isHttpPost() {
		return $this->method() === 'POST';
	}

	public function isHttpGet() {
		return $this->method() === 'GET';
	}

	/**
	 * @return bool|string
	 */
	public function getPath(): bool|string {
		$path = $_SERVER['REQUEST_URI'] ?? '/';
		$position = strpos($path, '?');
		return $position === false ? $path : substr($path, 0, $position);
	}

	public function input(string $key) {
		return $this->input[$key] ?? null;
	}

}
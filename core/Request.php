<?php

namespace core;


class Request
{
	/**
	 * @var string
	 */
	public $path;

	/**
	 * @var array
	 */
	public $params;


	public function __construct()
	{
		$this->path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
		$this->params = $this->getParams();
	}

	/**
	 * @return array
	 */
	public function getParams(): array
	{
		$str = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
		parse_str($str, $output);

		return $output;
	}

	/**
	 * @param string|null $name
	 *
	 * @return mixed
	 */
	public function get(string $name = null)
	{
		if($name) {
			return $_GET[$name];
		}

		return $_GET;
	}

	/**
	 * @return mixed
	 */
	public function post()
	{
		return $_POST;
	}

	/**
	 * @param string $url
	 */
	public function redirect($url): void
	{
		header('Location: ' . $url);
		die();
	}

	/**
	 * @return bool
	 */
	public function isPost(): bool
	{
		return $_SERVER['REQUEST_METHOD'] === 'POST';
	}

}
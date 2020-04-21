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
	 * @return mixed
	 */
	public function get()
	{
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

}
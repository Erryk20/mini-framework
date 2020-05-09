<?php

namespace core;

/**
 * Class View
 * @package core
 */
class View
{
	/**
	 * @param string     $view
	 * @param array      $data
	 * @param Controller $controller
	 *
	 * @throws \ErrorException
	 */
	public function render(string $view, array $data = [], Controller $controller = null)
	{
		$path = '';
		if ($controller) {
			$path = $controller->folderViews . "/";
		}

		$this->_view = "../views/{$path}" . $view . '.php';

		if (!file_exists($this->_view)) {
			http_response_code(404);
			throw new \ErrorException('View cannot be found');
		}

		extract($data, EXTR_OVERWRITE);
		unset($data, $view, $controller);

		ob_start();
		ob_implicit_flush(false);

		require_once ($this->_view);


		echo ob_get_clean();
	}

	/**
	 * @var Controller
	 */
	private static $_controller;

	/**
	 * @var string
	 */
	private $_view;

}
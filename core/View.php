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
	 * @return string
	 * @throws \ErrorException
	 */
	public function render(string $view, array $data = [], Controller $controller = null): string
	{
		if(!self::$_controller) {
			self::$_controller = $controller;
		}

		$this->_view = '../views/' . $controller->folderViews . '/' . $view . '.php';
		$this->_layoutPath = '../views/layouts/' . $controller->layout . '.php';

		if (!file_exists($this->_view)) {
			throw new \ErrorException('View cannot be found');
		}

		extract($data, EXTR_OVERWRITE);
		unset($data, $view, $controller);

		ob_start();
		ob_implicit_flush(false);

		require ($this->_view);

		$content = ob_get_clean();

		if (!file_exists($this->_layoutPath)) {
			return $content;
		}

		foreach (get_defined_vars() AS $key => $value) {
			if ($key === 'content') continue;

			unset($$key);
		}
		unset($key, $value);

		ob_implicit_flush(false);

		require ($this->_layoutPath);

		return ob_get_clean();
	}

	/**
	 * @var Controller
	 */
	private static $_controller;

	/**
	 * @var string
	 */
	private $_view;

	/**
	 * @var string
	 */
	private $_layoutPath;

}
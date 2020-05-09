<?php

namespace core;

/**
 * Class Controller
 * @property string $folderViews
 * @property string $layout
 *
 * @package core
 */
class Controller
{
	/**
	 * @var string
	 */
	public $folderViews;

	/**
	 * @var string
	 */
	public $layout = 'main';

	/**
	 * Controller constructor.
	 *
	 * @param string $folderViews
	 */
	public function __construct (string $folderViews)
	{
		$this->folderViews = $folderViews;
	}

	/**
	 * @param string $view
	 * @param array  $data
	 *
	 * @throws \ErrorException
	 */
	protected function render(string $view, array $data = [])
	{
		$this->_layoutPath = '../views/layouts/' . $this->layout . '.php';

		ob_start();
		ob_implicit_flush(false);

		(new View)->render($view, $data, $this);

		ob_implicit_flush(false);

		$content = ob_get_clean();

		if (!file_exists($this->_layoutPath)) {
			echo $content;

			return;
		}

		foreach (get_defined_vars() AS $key => $value) {
			if ($key === 'content') continue;

			unset($$key);
		}
		unset($key, $value);

		require ($this->_layoutPath);

	}

	/**
	 * @param string $view
	 * @param array  $data
	 *
	 * @return false|string
	 * @throws \ErrorException
	 */
	protected function renderPartial(string $view, array $data = [])
	{
		ob_start();
		ob_implicit_flush(false);

		(new View)->render($view, $data);

		return ob_get_clean();
	}

	/**
	 * @var string
	 */
	private $_layoutPath;

}
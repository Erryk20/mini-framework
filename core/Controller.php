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
		echo (new View)->render($view, $data, $this);
	}

}
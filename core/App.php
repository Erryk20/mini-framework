<?php
namespace core;

class App
{

	/**
	 * @param string $key
	 *
	 * @return mixed|null
	 */
	public static function getConfig(string $key)
	{
		return self::$_config[$key] ?? null;
	}

	/**
	 * @param array $config
	 *
	 * @throws \ErrorException
	 * @throws \ReflectionException
	 */
	public static function run(array $config): void
	{
		session_start();
		self::$_config = $config;

		$request = self::request();

		$path = $request->path;
		$params = $request->params;

		$controller = $action = '';
		$arrayPath = array_filter(explode('/', $path));
		if ($arrayPath) {
			[$controller, $action] = $arrayPath;
		}

		$controller = $controller ?: 'site';
		$folderViews = $controller;

		$action = $action ?: 'index';
		$action = 'action' . ucfirst($action);
		$controller = 'controllers\\' . ucfirst($controller) . 'Controller';

		if (!class_exists($controller)) {
			throw new \ErrorException("{$controller} Controller does not exist");
		}

		/** @var Controller $objController */
		$objController = new $controller($folderViews);

		if (!method_exists($objController, $action)) {
			http_response_code(404);
			throw new \ErrorException('Action does not exist');
		}

		$reflection = new \ReflectionClass($objController);
		$parameters = $reflection->getMethod($action)->getParameters();
		$needParameters = array_column($parameters, 'name');

		$arg = [];
		foreach ($needParameters as $parameter){
			if (isset($params[$parameter])) {
				$arg[$parameter] = $params[$parameter];
			}
		}

		try {
			call_user_func_array([$objController, $action], $arg);
		} catch (\ArgumentCountError $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * @return Request
	 */
	public static function request()
	{
		return new Request();
	}

	/**
	 * @var array
	 */
	private static $_config;
}
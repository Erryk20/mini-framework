<?php


namespace widgets;


use core\App;

class Url
{

	/**
	 * @param array $params
	 *
	 * @return string
	 */
	public static function create(array $params): string
	{
		$pathToAction = '';

		foreach ($params as $key => $value) {
			if(is_int($key)) {
				$pathToAction = $value;
				unset($params[$key]);

				continue;
			}
		}

		return $pathToAction . '?' . http_build_query($params);
	}


	/**
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return bool
	 */
	public static function hasParams(string $key, $value): bool
	{
		$request = App::request();
		$requestParams = $request->params;

		if(array_key_exists($key, $requestParams)) {

			return $requestParams[$key] == $value;
		}

		return false;
	}

}
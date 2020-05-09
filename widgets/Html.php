<?php


namespace widgets;


class Html
{
	/**
	 * @param string $text
	 * @param array  $params
	 * @param array  $options
	 *
	 * @return string
	 */
	public static function a(string $text, array $params, array $options = []): string
	{
		$strOptions = '';
		foreach ($options AS $key => $value) {
			$strOptions .= " {$key} = '{$value}'";
		}

		return "<a href='" . Url::create($params) . "'{$strOptions}>{$text}</a>";
	}

}
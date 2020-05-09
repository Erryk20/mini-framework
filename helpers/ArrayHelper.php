<?php
namespace helpers;

use core\ActiveModel;

class ArrayHelper
{


	/**
	 * @param ActiveModel[] $models
	 *
	 * @return array
	 */
	public static function convertToArray(array $models): array
	{
		$result = [];

		foreach ($models AS $key => $model) {
			if ($model instanceof ActiveModel) {
				$result[$key] = $model->getAttributes();
			}
		}

		return $result;
	}

}
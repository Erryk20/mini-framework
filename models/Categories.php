<?php

namespace models;

use core\ActiveModel;

/**
 * Class Task
 *
 * @property integer $categories_id
 * @property integer $parent_id
 */
class Categories extends ActiveModel
{

	/**
	 * @return string
	 */
	public static function tableName(): string
	{
		return 'categories';
	}
}
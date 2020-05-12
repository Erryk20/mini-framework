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



	/**
	 * @return array
	 */
	public static function getTreeArray(): array
	{
		$categories = self::find()
						  ->select(['categories_id', 'parent_id'])
						  ->all();

		return self::buildTree($categories);
	}


	/**
	 * @param Category[] $categories
	 * @param int        $parentId
	 *
	 * @return array
	 */
	public static function buildTree (array &$categories, $parentId = null): array
	{
		$result = [];

		foreach ($categories as $key => $category) {
			if($category->parent_id === 0) {
				$result[$category->categories_id] = $category->categories_id;

				unset($categories['$key']);

				continue;
			}

			if ($category->parent_id == $parentId) {
				$children = self::buildTree($categories, $category->id);

				$result[$category->categories_id] = $children ? $children : $category->categories_id;
			}
		}

		return $result;
	}

}
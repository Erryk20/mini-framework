<?php

namespace models;

use core\ActiveModel;

/**
 * Class Task
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string  $name
 */
class Category extends ActiveModel
{

	/**
	 * @return string
	 */
	public static function tableName(): string
	{
		return 'category';
	}


	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'parent_id' => "Parent ID",
			'name' => 'Назва категорії',
		];
	}


	/**
	 * @return array
	 */
	public static function getTreeArray(): array
	{
		return self::buildTree(self::find()->all());
	}

	/**
	 * @param Category[] $categories
	 * @param int        $parentId
	 *
	 * @return array
	 */
	public static function buildTree (array $categories, $parentId = 0): array
	{
		$result = [];

		foreach ($categories as $category) {
			if ($category->parent_id == $parentId) {
				$children = self::buildTree($categories, $category->id);
				if ($children) {
					$result[$category->id] = [
						'name' => $category->name,
						'children' => $children,
					];
				} else {
					$result[$category->id] = ['name' => $category->name];
				}
			}
		}

		return $result;
	}

}
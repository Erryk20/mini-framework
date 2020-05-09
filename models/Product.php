<?php

namespace models;

use core\ActiveModel;

/**
 * Class Task
 *
 * @property integer $id
 * @property integer $category_id
 * @property string  $name
 * @property double  $price
 * @property string  $create_at
 */
class Product extends ActiveModel
{

	/**
	 * @var string
	 */
	public $src = '/images/default.png';

	/**
	 * @var string
	 */
	public $sort;

	/**
	 * @return string
	 */
	public static function tableName(): string
	{
		return 'product';
	}


	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'category_id' => "Category ID",
			'name' => 'Назва товара',
			'price' => 'Ціна товара',
			'create_at' => 'Дата створення',
			'sort' => 'Виберіть сортування',
		];
	}

}
<?php


namespace models;


class ProductSearch extends Product
{

	public static function search($params)
	{
		$query = self::find()->where(['category_id' => $params['id']]);

		if ($sort = $params['sort'] ?? false){
			$direction = 1;
			if(strpos(trim($sort), '-') === 0){
				$sort = str_replace('-', '', $sort);
				$direction = -1;
			}

			$query->order([$sort => $direction]);
		};

		return $query->all();

	}

}
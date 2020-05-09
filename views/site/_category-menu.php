<?php
use widgets\Html;
use widgets\Url;
use models\Category;

/**
 * @param array $categories
 */

function buildMenu($categories)
{
	foreach ($categories as $categoryId => $node)
	{
		echo "<li " . (Url::hasParams('id', $categoryId) ? "id='deepest'" : '')  . ">"
			. Html::a(
				$node['name'],
				['category', 'id' => $categoryId],
				[
					'data-key-template' => 'productItem',
					'data-url' => "category?id={$categoryId}",
				]
			);
		if ( ! empty($node['children'])) {
			echo "<ul>";
			buildMenu($node['children']);
			echo "</ul>";
		}
		echo "</li>";
	}
}

echo "<ul class='dropdown'>";
buildMenu(Category::getTreeArray());
echo "</ul>";

<?php

use core\View;
use models\Category;
use widgets\Html;

/**
 * @var View       $this
 * @var Category[] $categories
 * @var array      $treeCategories
 */

$count = count($categories);
?>

<div class="row">
	<?php foreach ($categories AS $key => $category): ?>
	<?= ($key % 4 === 0)  ? "<div class='row'>" : "" ?>

		<div class="card">
			<img class="card-img-top" src="/images/default.png" alt="<?= $category->name ?>">
			<div class="card-body">
				<?= Html::a($category->name, ['category', 'id' => $category->id], ['class' => "product-name"]) ?>
			</div>
		</div>
		<?= (($key && $key % 3 === 0) || ($count === $key+1))  ? "</div>" : "" ?>
	<?php endforeach; ?>
</div>

<pre>
	<?php print_r($tree) ?>
</pre>

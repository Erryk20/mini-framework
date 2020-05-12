<?php
use core\View;
use widgets\ActiveForm;
use models\Product;

/**
 * @var View    $this
 * @var string  $productsInfoJson
 * @var Product $product
 */
?>
<script>
	let itemsInfo = <?= $productsInfoJson ?>
</script>

<div id="sort" class="form-group">
	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($product, 'sort')->selectInput(
			[
				"price" => 'Cпочатку дешевші',
				"-price" => 'Cпочатку дорогі',
				"name" => 'По алфавіту A-Z',
				"-name" => 'По алфавіту Z-A',
				"-create_at" => 'Спочатку нові',
				"create_at" => 'Спочатку давні',
			],
			['prompt' => '']
) ?>
</div>

<?php ActiveForm::end() ?>

<div class="list-items"></div>

<div class="modal fade bd-example-modal-lg" id="productModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Shopping cart</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Image</th>
							<th scope="col">Name</th>
							<th scope="col">price</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Checkout</button>
			</div>
		</div>
	</div>
</div>


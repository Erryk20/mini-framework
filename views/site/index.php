<?php

use core\View;
use models\Task;
use models\Order;

use widgets\Pagination;
use widgets\ActiveForm;

/**
 * @var View       $this
 * @var Pagination $pagination
 * @var Task[]     $models
 * @var Order      $order
 * @var int        $page
 * @var bool       $authorized
 */
?>
<?php $form = ActiveForm::begin(); ?>
	<div class="form-group row">
		<div class="col-sm-6">
			<button type="submit" class="btn btn-primary" style="float: right;">Застосувати</button>
		</div>
	</div>

<?= $form->field($order, 'username')->selectInput(
	[
		1 => 'А-Я',
		-1 => 'Я-А',
	],
	['prompt' => 'Виберіть сортування'])
?>

<?= $form->field($order, 'email')->selectInput(
	[
		1 => 'А-Я',
		-1 => 'Я-А',
	],
	['prompt' => 'Виберіть сортування'])
?>

<?= $form->field($order, 'status')->selectInput(
	[
		1 => 'Спочатку невиконанні',
		-1 => 'Спочатку виконанні',
	],
	['prompt' => 'Виберіть сортування'])
?>
<input type="hidden" name="page" value="<?= $page ?>">
<?php ActiveForm::end() ?>
<div class="container">
	<div class="row" style="margin: 50px 0 50px 0;">
		<?php foreach ($models as $model) : ?>
			<div class="col-md-4">
				<p><b>Користувач: </b><?= $model->username ?></p>
				<p><b>E-mail: </b><?= $model->email ?></p>
				<p><b>Текст задачі: </b> <?= $model->description ?></p>
				<p><b>Виконана: </b><?= $model->status ? 'Так' : 'Ні' ?></p>

				<?php if($model->is_change) : ?>
					<p style="color: grey;">Відредагована адміністратором</p>
				<?php endif; ?>

				<?php if($authorized) : ?>
					<a class="btn btn-primary" href="<?= "/task/update?id={$model->id}"?>">Оновити</a>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<?= $pagination->getPaginationHtml() ?>
<?php

use  \widgets\ActiveForm;
use core\View;
use models\Task;

/**
 * @var View        $this
 * @var bool        $authorized
 * @var Task        $model
 * @var string|null $alertMessage
 */

?>

<?php if($alertMessage) : ?>
<div class="alert alert-primary" role="alert">
	<?= $alertMessage ?>
</div>
<?php endif; ?>

<?php $form = ActiveForm::begin(['method' => 'POST']); ?>
	<?= $form->field($model, 'username')->textInput() ?>
	<?= $form->field($model, 'email')->emailInput() ?>
	<?= $form->field($model, 'description')->textareaInput() ?>

	<?php if($authorized): ?>
		<?= $form->field($model, 'status')->checkboxInput() ?>
	<?php endif; ?>

	<div class="form-group row">
		<div class="col-sm-6">
			<button type="submit" class="btn btn-primary" style="float: right;">Зберегти</button>
		</div>
	</div>
<?php ActiveForm::end() ?>
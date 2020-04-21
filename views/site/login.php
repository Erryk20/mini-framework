<?php

use \widgets\ActiveForm;
use core\View;
use models\Login;

/**
 * @var View   $this
 * @var Login  $model
 * @var string $alertMessage
 */

?>

<?php if($alertMessage) : ?>
	<div class="alert alert-danger" role="alert">
		<?= $alertMessage ?>
	</div>
<?php endif; ?>

<?php $form = ActiveForm::begin(['method' => 'POST']); ?>

<?= $form->field($model, 'login')->textInput() ?>
<?= $form->field($model, 'password')->passwordInput() ?>

<button type="submit" class="btn btn-primary">Ввійти</button>
<?php ActiveForm::end() ?>

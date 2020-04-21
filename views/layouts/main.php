<?php
/**
 * @var $content string
 */

use models\User;

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
</head>
<body>
<div class="wrap">
	<nav class="navbar-inverse navbar-fixed-top navbar">
		<div class="container">
			<div class="navbar-collapse">
				<a class="btn btn-primary" style="float: left;" href="/">Головна</a>
				<?php if (User::isAuthorized()) : ?>
					<a class="btn btn-primary" style="float: right; margin-left: 5px;" href="/site/logout">Вихід</a>
				<?php else: ?>
					<a class="btn btn-primary" style="float: right; margin-left: 5px;" href="/site/login">Вхід</a>
				<?php endif; ?>
				<a class="btn btn-primary" style="float: right;" href="/task/create">Додати задачу</a>
			</div>
		</div>
	</nav>
	<div class="container">
		<?= $content ?>
	</div>
</div>
<footer class="footer">
	<div class="container">
	</div>
</footer>

<script src="/js/jquery.min.js" type="text/javascript"></script>
<script src="/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>
<?php
use core\Controller;

/**
 * @var            $content string
 * @var Controller $this
 */

use models\User;
use core\View;

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/css/tendina.css">
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
			</div>
		</div>
	</nav>
	<div id="main-content" class="container">
		<div class="row">
			<div class="col-md-3">
				<?php (new View)->render('site/_category-menu'); ?>
			</div>
			<div class="col-md-9">
				<?= $content ?>
			</div>
		</div>

	</div>
</div>
<footer class="footer">
	<div class="container">
	</div>
</footer>

<script src="/js/jquery.min.js" type="text/javascript"></script>
<script src="/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/js/tendina.min.js"></script>
<script src="/js/content-construktor.js"></script>
<script src="/js/init-page.js"></script>

</body>
</html>
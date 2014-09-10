<?php

?>

<!DOCTYPE html>
<html>

<head>
	<title>Fuzzy Search</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name='Description' content='fuzzy search mockup' />
	<meta name="author" content="liu tong">
	<link rel="shortcut icon" href="favicon.ico">

	<script type='text/javascript' src='js/lib/jquery-1.7.2.min.js'></script>
	<link type='text/css' href='css/bootstrap.css' rel='stylesheet' />
	<script type='text/javascript' src='js/lib/bootstrap.min.js'></script>

	<link href="css/style.css" rel="stylesheet">
</head>

<body >
	<h1 class="text-center">Fuzzy Search</h1>
	<div class='container'>
		<div class="lista well"></div>
		<div class="form-group">
			<label for="indirizzoinput">indirizzo</label>
			<input type="text" class="form-control" id="indirizzoinput" placeholder="inserire un posto">

		</div>
		<button id="conferma"  class="btn btn-default">Conferma</button>
	</div>

</div>

<div id="footer">
	<div class="container">
		<div class="text-muted text-center"> <a href="tables.php">DEMO</a></div>
	</div>
</div>

</body>
<script type='text/javascript' src='js/main.js'></script>
</html>
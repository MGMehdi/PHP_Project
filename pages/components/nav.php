<?php
session_start();

if (empty($_SESSION['surname'])) {
	$login = 'Login';
} else {
	$login = $_SESSION['surname'] . ' ' . $_SESSION['name'];
}

?>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<link rel="stylesheet" href="../../css/style.css">
</head>

<body>
	<nav class="navbar navbar-expand-lg">
		<a class="navbar-brand" href="./home.php">E-Local</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="./search.php">Search</a>
				</li>
			</ul>
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="profil.php"><?php echo $login ?></a>
				</li>
			</ul>
		</div>
	</nav>

</body>

</html>
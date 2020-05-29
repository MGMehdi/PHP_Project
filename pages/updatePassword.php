<?php
include 'components/header.php';
include 'components/nav.php';
include '../objects/database.php';

if (empty($_SESSION['surname'])) {
	header('Location: login.php');
}

$db = new Database();
$errors = array('pass' => '', 'secondPass' => '');

if (isset($_POST['submit'])) {
	if (empty($_POST['pass'])) {
		$errors['pass'] = "Entrez votre mot de passe";
	} else if (strlen($_POST['pass']) < 12) {
		$errors['pass'] = "Mot de passe trop court";
	} else if ($_POST['pass'] != $_POST['secondPass']) {
		$errors['secondPass'] = "Mot de passe différent";
	} else {
		$user = new User($_SESSION['id'], '', '', '', $_POST['pass'], '', '');
		if ($db->updatePassword($user)) {
			header('Location: profil.php');
		}
	}
}
?>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/style.css">
	<title>Mon compte</title>
</head>

<body>

	<div class="container">
		<div id="loginCard" class="card" style="width: 30rem;">
			<div class="card-body">
				<h3 class="card-title text-center">Changer mon profil</h3>
				<form action="updatePassword.php" method="post">
					<div class="form-group">
						<label for="mail">Mot de passe</label>
						<input type="password" class="form-control" name="pass">
						<div class="inputError"><?php echo $errors['pass'] ?></div>
					</div>
					<div class="form-group">
						<label for="pass">Écrivez à nouveau votre mot de passe</label>
						<input type="password" class="form-control" name="secondPass">
						<div class="inputError"><?php echo $errors['secondPass'] ?></div>
					</div>
					<div class="text-center">
						<input type="submit" class="btn btn-secondary" name="submit" value="Enregistrer">
					</div>
				</form>
			</div>
		</div>
	</div>

</body>

</html>
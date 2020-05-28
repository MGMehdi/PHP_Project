<?php
include 'components/header.php';
include 'components/nav.php';
include '../objects/database.php';

if (empty($_SESSION['surname'])) {
	header('Location: login.php');
}

$db = new Database();

$errors = array('name' => '', 'surname' => '', 'mail' => '');
$user = $db->getUser($_SESSION['id']);

if (isset($_POST['submit'])) {
	if (empty($_POST['name'])) {
		$errors['name'] = "Entrez votre nom";
	} else if (empty($_POST['surname'])) {
		$user['name'] = $_POST['name'];
		$errors['surname'] = "Entrez votre prénom";
	} else if (empty($_POST['mail'])) {
		$user['name'] = $_POST['name'];
		$user['surname'] = $_POST['surname'];
		$errors['mail'] = "Entrez votre adresse mail";
	} else {
		$user = new User($_SESSION['id'], $_POST['name'], $_POST['surname'], $_POST['mail'], '', '', '');
		if ($db->updateUser($user)) {
			$_SESSION['name'] = htmlspecialchars($_POST['name']);
			$_SESSION['surname'] = htmlspecialchars($_POST['surname']);
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
				<form action="updateUser.php" method="post">
					<div class="form-group">
						<label for="mail">Nom</label>
						<input type="text" class="form-control" name="name" value="<?php echo $user->getName() ?>">
						<div class="inputError"><?php echo $errors['name'] ?></div>
					</div>
					<div class="form-group">
						<label for="mail">Prénom</label>
						<input type="text" class="form-control" name="surname" value="<?php echo $user->getSurname() ?>">
						<div class="inputError"><?php echo $errors['surname'] ?></div>
					</div>
					<div class="form-group">
						<label for="mail">Mail</label>
						<input type="email" class="form-control" name="mail" value="<?php echo $user->getMail() ?>">
						<div class="inputError"><?php echo $errors['mail'] ?></div>
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
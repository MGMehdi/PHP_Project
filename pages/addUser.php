<?php
include 'components/header.php';
include 'components/nav.php';
require_once '../objects/database.php';
require_once '../objects/user.php';

if (!empty($_SESSION['surname'])) {
	header('Location: profil.php');
}

$errors = array('name' => '', 'surname' => '', 'mail' => '', 'pass' => '', 'secondPass' => '');
$user = array('name' => '', 'surname' => '', 'mail' => '');

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
	} else if (empty($_POST['pass'])) {
		$user['name'] = $_POST['name'];
		$user['surname'] = $_POST['surname'];
		$user['mail'] = $_POST['mail'];
		$errors['pass'] = "Entrez votre mot de passe";
	} else if (strlen($_POST['pass']) < 12) {
		$user['name'] = $_POST['name'];
		$user['surname'] = $_POST['surname'];
		$user['mail'] = $_POST['mail'];
		$errors['pass'] = "Mot de passe trop court. Minimum 12 caractères.";
	} else if ($_POST['pass'] != $_POST['secondPass']) {
		$user['name'] = $_POST['name'];
		$user['surname'] = $_POST['surname'];
		$user['mail'] = $_POST['mail'];
		$errors['secondPass'] = "Mot de passe différent";
	} else {
		$db = new Database();
		$user = new User('', $_POST['name'], $_POST['surname'], $_POST['mail'], $_POST['pass'], '', '');
		if ($db->addUser($user)) {
			session_start();
			$_SESSION['id'] = $user->getId();
			$_SESSION['name'] = $user->getName();
			$_SESSION['surname'] = $user->getSurname();
			$_SESSION['seller'] = $user->getSeller();
			$_SESSION['admin'] = $user->getAdmin();
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
	<title>S'inscrire</title>
</head>

<body>
	<div class="container">
		<div id="loginCard" class="card" style="width: 30rem;">
			<div class="card-body">
				<h3 class="card-title text-center">S'inscrire</h3>
				<form action="addUser.php" method="post">
					<div class="form-group">
						<label for="name">Nom</label>
						<input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user['name']) ?>">
						<div class="inputError"><?php echo $errors['name'] ?></div>
					</div>
					<div class="form-group">
						<label for="surname">Prénom</label>
						<input type="text" class="form-control" name="surname" value="<?php echo htmlspecialchars($user['surname']) ?>">
						<div class="inputError"><?php echo $errors['surname'] ?></div>

					</div>
					<div class="form-group">
						<label for="mail">Mail</label>
						<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="form-control" name="mail" value="<?php echo htmlspecialchars($user['mail']) ?>">
						<div class="inputError"><?php echo $errors['mail'] ?></div>

					</div>
					<div class="form-group">
						<label for="pass">Mot de passe</label>
						<input type="password" class="form-control" name="pass">
						<div class="inputError"><?php echo $errors['pass'] ?></div>

					</div>
					<div class="form-group">
						<label for="secondPass">Écrivez à nouveau votre mot de passe</label>
						<input type="password" class="form-control" name="secondPass">
						<div class="inputError"><?php echo $errors['secondPass'] ?></div>
					</div>
					<div class="text-center">
						<input type="submit" class="btn btn-secondary" name="submit" value="S'inscrire">
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

</html>
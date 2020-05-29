<?php
include 'components/header.php';
include 'components/nav.php';
include '../objects/user.php';
include '../objects/database.php';

if (empty($_SESSION['surname']) || $_SESSION['admin'] == 0) {
	header('Location: home.php');
}

$db = new Database();
$errors = array('name' => '', 'surname' => '', 'mail' => '');
$start = false;
$errorUser = array('name' => '', 'surname' => '', 'mail' => '');
$user = array();

if (isset($_POST['submitSearch'])) {
	$user = $db->GetUser($_POST['id']);
	$start = true;
} else if (isset($_POST['update'])) {
	if (empty($_POST['name'])) {
		$errors['name'] = "Entrez un nom";
	} else if (empty($_POST['surname'])) {
		$errorUser['name'] = $_POST['name'];
		$errors['surname'] = "Entrez un prénom";
	} else if (empty($_POST['mail'])) {
		$errorUser['name'] = $_POST['name'];
		$errorUser['surname'] = $_POST['surname'];
		$errors['mail'] = "Entrez une adresse mail";
	} else {
		$user = new User($_POST['id'], $_POST['name'], $_POST['surname'], $_POST['mail'], '', '', $_POST['seller']);
		if ($db->updateUser($user) && $db->beASeller($user)) {
			header('Location: profil.php');
		}
	}
} else if (isset($_POST['delete'])) {
	$db->DeleteUser($_POST['id']);
} else if (isset($_POST['reset'])) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < 12; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	$to = $_POST['mail'];
	$subject = "E-Local - Votre nouveau mot de passe";
	$body = 'Bonjour ' . $_POST['name'] . htmlspecialchars(",\n Vous avez fait une demande de changement de mot de passe auprès de nos modérateurs.\n
	Voici votre nouveau mot de passe :\n
	") . $randomString . "\n
	Si ce n'était pas vous, veuillez directement changer votre mot de passe.\n\n
	Cordialement\n\n
	L'équipe E-Local";
	$headers = "From: sender\'s email";

	mail($to, $subject, utf8_decode($body), $headers);
	$u = new User($_POST['id'], '', '', '', $randomString, '', '');
	$db->updatePassword($u);

	echo $randomString;
}


?>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/style.css">
	<title>Modifier un utilisateur</title>
</head>

<body>
	<form action="adminUser.php" method="post">
		<div class="container">
			<div id="loginCard" class="card" style="width: 30rem;">
				<div class="card-body">
					<h3 class="card-title text-center">Modifier un utilisateur</h3>

					<div class="form-group">
						<label for="id">Id de l'utilisateur</label>
						<input type="number" class="form-control" name="id" id="id" <?php
																					if ($start) {
																						echo 'value=' . $_POST['id'];
																					}
																					?>>
						<div class="inputError"><?php if ($user === null) echo "Utilisateur introuvable" ?></div>
						<div class="text-center">
							<input type="submit" class="btn btn-secondary" name="submitSearch" value="Chercher">
						</div>
					</div>
					<div class="form-group">
						<label for="name">Nom</label>
						<input type="text" class="form-control" name="name" value="<?php
																					try {
																						echo htmlspecialchars($user->getName());
																					} catch (\Throwable $th) {
																						//throw $th;
																					} ?>">
						<div class="inputError"><?php echo $errors['name'] ?></div>
					</div>
					<div class="form-group">
						<label for="surname">Prénom</label>
						<input type="text" class="form-control" name="surname" value="<?php
																						try {
																							echo htmlspecialchars($user->getSurname());
																						} catch (\Throwable $th) {
																							//throw $th;
																						} ?>">
						<div class="inputError"><?php echo $errors['surname'] ?></div>
					</div>
					<div class="form-group">
						<label for="mail">Mail</label>
						<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="form-control" name="mail" value="<?php
																					try {
																						echo htmlspecialchars($user->getMail());
																					} catch (\Throwable $th) {
																						//throw $th;
																					} ?>">
						<div class="inputError"><?php echo $errors['mail'] ?></div>
					</div>
					<div class="form-group">
						<label for="Seller">Vendeur</label>
						<select name="seller" class="form-control">
							<option value="" <?php if ($user == null)  echo 'selected' ?> disabled></option>
							<option value="5" <?php try {
													if ($user->getSeller() == 5) echo 'selected';
												} catch (\Throwable $th) {
													//throw $th;
												} ?>>Refusé</option>
							<option value="1" <?php try {
													if ($user->getSeller() == 1) echo 'selected';
												} catch (\Throwable $th) {
													//throw $th;
												} ?>>Accepté</option>
							<option value="2" <?php try {
													if ($user->getSeller() == 2) echo 'selected';
												} catch (\Throwable $th) {
													//throw $th;
												} ?>>En attende</option>
						</select>
					</div>
					<div class="text-center">
						<input type="button" class="btn btn-secondary" name="submit" value="Enregistrer" onclick="Open('update')">
						<input type="button" class="btn btn-warning" name="reset" value="Réinitialiser  mot de passe" onclick="Open('reset')">
						<input type="button" class="btn btn btn-danger" value="Supprimer" onclick="Open('delete')">
					</div>

				</div>
			</div>
		</div>
		<div id="cardBackground" onclick="Close()"></div>
		<div id="updateCard" class="card text-center">
			<div class="card-body">
				<h3 class="card-title">Valider la modification ?</h3>
				<h5></h5>
				<input type="submit" name="update" class="btn btn-danger" value="Oui">
				<input type="button" name="Non" class="btn btn-success" value="Non" onclick="Close()">
			</div>
		</div>
		<div id="deleteCard" class="card text-center">
			<div class="card-body">
				<h3 class="card-title">Supprimer cet utilisateur ?</h3>
				<h5></h5>
				<input type="submit" name="delete" class="btn btn-danger" value="Oui">
				<input type="button" name="Non" class="btn btn-success" value="Non" onclick="Close()">
			</div>
		</div>
		<div id="resetCard" class="card text-center">
			<div class="card-body">
				<h3 class="card-title">Réinitialiser le mot de passe ?</h3>
				<h5></h5>
				<input type="submit" name="reset" class="btn btn-danger" value="Oui">
				<input type="button" name="Non" class="btn btn-success" value="Non" onclick="Close()">
			</div>
		</div>

	</form>
	<script>
		function Open(value) {
			document.getElementById('cardBackground').style.display = 'block';
			switch (value) {
				case 'update':
					document.getElementById('updateCard').style.display = 'block';
					break;
				case 'delete':
					document.getElementById('deleteCard').style.display = 'block';
					break;
				case 'reset':
					document.getElementById('resetCard').style.display = 'block';
					break;

				default:
					break;
			}

		}

		function Close() {
			document.getElementById('cardBackground').style.display = 'none';
			document.getElementById('updateCard').style.display = 'none';
			document.getElementById('deleteCard').style.display = 'none';
			document.getElementById('resetCard').style.display = 'none';
		}
	</script>

</body>

</html>
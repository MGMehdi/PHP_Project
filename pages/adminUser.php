<?php
include 'components/header.php';
include 'components/nav.php';
include '../objects/user.php';
include '../objects/database.php';

$db = new Database();
$user = '';
$errors = array('name' => '', 'surname' => '', 'mail' => '');

if (isset($_POST['submitSearch'])) {
	$user = $db->GetUser($_POST['id']);
} else if (isset($_POST['submit'])) {
	if (empty($_POST['name'])) {
		$errors['name'] = "Entrez un nom";
	} else if (empty($_POST['surname'])) {
		$user['name'] = $_POST['name'];
		$errors['surname'] = "Entrez un prénom";
	} else if (empty($_POST['mail'])) {
		$user['name'] = $_POST['name'];
		$user['surname'] = $_POST['surname'];
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
	$to_email = $_POST['mail'];
	$subject = "E-Local - Votre nouveau mot de passe";
	$body = 'Bonjour ' . $_POST['name'] . htmlspecialchars(",\n Vous avez fait une demande de changement de mot de passe auprès de nos modérateurs.\n
	Voici votre nouveau mot de passe :\n
	") . $randomString . "\n
	Si ce n'était pas vous, veuillez directement changer votre mot de passe.\n\n
	Cordialement\n\n
	L'équipe E-Local";
	$headers = "From: sender\'s email";

	if (mail($to_email, $subject, utf8_decode($body), $headers)) {
		$u = new User($_POST['id'], '', '', '', $randomString, '', '');
		$db->updatePassword($u);
		echo "Email successfully sent to $to_email...";
	} else {
		echo "Email sending failed...";
	}
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
																					if ($user != null) {
																						echo 'value=' . $_POST['id'];
																					}
																					?>>
						<div class="inputError"><?php if ($user === null) echo "Utilisateur introuvable" ?></div>
						<div class="text-center">
							<input type="submit" class="btn btn-secondary" name="submitSearch" value="Chercher">
						</div>
					</div>
					<div class="form-group">
						<label for="mail">Nom</label>
						<input type="text" class="form-control" name="name" value="<?php
																					try {
																						echo $user->getName();
																					} catch (\Throwable $th) {
																						//throw $th;
																					} ?>">
						<div class="inputError"><?php echo $errors['name'] ?></div>
					</div>
					<div class="form-group">
						<label for="mail">Prénom</label>
						<input type="text" class="form-control" name="surname" value="<?php
																						try {
																							echo $user->getSurname();
																						} catch (\Throwable $th) {
																							//throw $th;
																						} ?>">
						<div class="inputError"><?php echo $errors['surname'] ?></div>
					</div>
					<div class="form-group">
						<label for="mail">Mail</label>
						<input type="email" class="form-control" name="mail" value="<?php
																					try {
																						echo $user->getMail();
																					} catch (\Throwable $th) {
																						//throw $th;
																					} ?>">
						<div class="inputError"><?php echo $errors['mail'] ?></div>
					</div>
					<div class="form-group">
						<label for="Seller">Vendeur</label>
						<select name="seller" class="form-control">
							<option value="" <?php if($user == null)  echo 'selected' ?> disabled></option>
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
						<input type="submit" class="btn btn-secondary" name="submit" value="Enregistrer">
						<input type="submit" class="btn btn-warning" name="reset" value="Réeinitialiser mot de passe">
						<input type="button" class="btn btn btn-danger" value="Supprimer" onclick="Open()">
					</div>

				</div>
			</div>
		</div>
		<div id="cardBackground" onclick="Close()"></div>
		<div id="updateCard" class="card text-center" style="width: 40rem; top:-30em">
			<div class="card-body">
				<h3 class="card-title">Valider la modification ?</h3>
				<h5></h5>
				<input type="submit" name="delete" class="btn btn-danger" value="Oui">
				<input type="button" name="Non" class="btn btn-success" value="Non" onclick="Close()">
			</div>
		</div>

	</form>
	<script>
		function Open(value) {
			document.getElementById('cardBackground').style.display = 'block';
			document.getElementById('updateCard').style.display = 'block';
		}

		function Close() {
			document.getElementById('cardBackground').style.display = 'none';
			document.getElementById('updateCard').style.display = 'none';
		}
	</script>

</body>

</html>
<?php
include 'components/header.php';
include 'components/nav.php';
include '../objects/user.php';
include '../objects/database.php';

$db = new Database();

if (empty($_SESSION['surname'])) {
	header('Location: login.php');
}

if (isset($_POST['MyProducts'])) {
	header('Location: myentreprise.php');
}

if (isset($_POST['BeASeller'])) {
	$user = new User($_SESSION['id'], '', '', '', '', '', 2);
	if ($db->beASeller($user)) {
		$_SESSION['seller'] = 2;
	}
	header('Location: profil.php');
}
if (isset($_POST['Disconnect'])) {
	session_unset();
	header('Location: login.php');
}
if (isset($_POST['DeleteMe'])) {
	$db->DeleteUser($_SESSION['id']);
	session_unset();
	header('Location: login.php');
}
if (isset($_POST['Update'])) {
	header('Location: updateUser.php');
}
if (isset($_POST['Password'])) {
	header('Location: updatePassword.php');
}
if (isset($_POST['adminSeller'])) {
	header('Location: adminSeller.php');
}
if (isset($_POST['adminUser'])) {
	header('Location: adminUser.php');
}
if (isset($_POST['adminEntreprise'])) {
	header('Location: adminEntreprise.php');
}

if (isset($_POST['Send'])) {
	$to = "mgmehdi@tutanota.com";
	$subject = "Utilisateur : ". $_SESSION['id']. " - ". utf8_decode($_POST['Subject']);
	mail($to, $subject, utf8_decode($_POST['Message']));
	header('Location: profil.php');
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
	<div class="container-fluid">
		<h1>Bienvenue <?php echo $_SESSION['surname'] ?></h1>
		<form action="profil.php" method="post">
			<?php if ($_SESSION['seller'] == 1 && !$_SESSION['admin']) { ?>
				<input type="submit" value="Mes productions" name="MyProducts">
			<?php } else if (!$_SESSION['seller'] && !$_SESSION['admin']) { ?>
				<input type="button" value="Devenir un vendeur" onclick="Open('seller')">
			<?php } ?>
			<?php if ($_SESSION['admin']) { ?>
				<input type="submit" value="Valider les vendeurs" name="adminSeller">
				<input type="submit" value="Modifier un utilisateur" name="adminUser">
				<input type="submit" value="Modifier une entreprise" name="adminEntreprise">
			<?php } ?>
			<input type="submit" value="Changer mes données" name="Update">
			<input type="submit" value="Changer de mots de passe" name="Password">
			<input type="submit" value="Déconnexion" name="Disconnect">
			<input type="button" value="Demander un support" name="Contact" onclick="Open('support')">
			<?php if (!$_SESSION['admin']) { ?>
				<input type="button" value="Supprimer mon compte" onclick="Open('delete')">
			<?php } ?>
		</form>

		<div id="cardBackground" class="text-center" onclick="Close('background')"></div>
		<div id="deleteCard" class="card" style="width: 40rem;">
			<div class="card-body">
				<h3 class="card-title">Vous nous quittez ?</h3>
				<h5>Etes-vous sûr de vouloir supprimer votre compte ?</h5>
				<form action="profil.php" method="post">
					<input type="submit" name="DeleteMe" class="btn btn-danger" value="Oui">
					<input type="button" name="Non" class="btn btn-success" value="Non" onclick="Close()">
				</form>
			</div>
		</div>

		<div id="sellerCard" class="card" style="width: 40rem;">
			<div class="card-body">
				<h3 class="card-title">Devenir un vendeur ?</h3>
				<h5>
					Etes-vous sûr de vouloir devenir un vendeur ?<br>
					Un modérateur devra valider cette demande.
				</h5>
				<form action="profil.php" method="post">
					<input type="submit" name="BeASeller" class="btn btn-danger" value="Oui">
					<input type="button" name="Non" class="btn btn-success" value="Non" onclick="Close()">
				</form>
			</div>
		</div>

		<div id="helpCard" class="card" style="width: 40rem; top:-10em">
			<div class="card-body">
				<h3 class="card-title">Demander un support</h3>
				<form action="profil.php" method="post">
					<label for="Subject">Sujet</label>
					<input type="text" class="form-control" name="Subject" id="">
					<label for="Message">Votre message</label>
					<textarea name="Message" id="Message" cols="" rows="10"></textarea>

					<input type="submit" name="Send" class="btn btn-danger" value="Envoyer">
					<input type="button" name="" class="btn btn-success" value="Anuler" onclick="Close()">
				</form>
			</div>
		</div>
	</div>


	<script>
		function Open(value) {
			document.getElementById('cardBackground').style.display = 'block';
			if (value == 'delete') {
				document.getElementById('deleteCard').style.display = 'block';
			} else if (value == 'seller') {
				document.getElementById('sellerCard').style.display = 'block';
			} else if (value == 'support') {
				document.getElementById('helpCard').style.display = 'block';
			}
		}

		function Close() {
			document.getElementById('cardBackground').style.display = 'none';
			document.getElementById('deleteCard').style.display = 'none';
			document.getElementById('sellerCard').style.display = 'none';
			document.getElementById('helpCard').style.display = 'none';
		}
	</script>


</body>

</html>
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
			<?php if ($_SESSION['seller']==1 && !$_SESSION['admin']) { ?>
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
			<?php if (!$_SESSION['admin']) { ?>
				<input type="button" value="Supprimer mon compte" onclick="Open('delete')">
			<?php } ?>
		</form>

		<div id="askDeleteBackground" class="text-center" onclick="Close('delete')">
			<div id="loginCard" class="card" style="width: 40rem;">
				<div class="card-body">
					<h3 class="card-title">Vous nous quittez ?</h3>
					<h5>Etes-vous sûr de vouloir supprimer votre compte ?</h5>
					<form action="profil.php" method="post">
						<input type="submit" name="DeleteMe" class="btn btn-danger" value="Oui">
						<input type="button" name="Non" class="btn btn-success" value="Non" onclick="Close('delete')">
					</form>
				</div>
			</div>
		</div>
		<div id="askBecomeSeller" class="text-center" onclick="Close('seller')">
			<div id="loginCard" class="card" style="width: 40rem;">
				<div class="card-body">
					<h3 class="card-title">Devenir un vendeur ?</h3>
					<h5>
						Etes-vous sûr de vouloir devenir un vendeur ?<br>
						Un modérateur devra valider cette demande.
					</h5>
					<form action="profil.php" method="post">
						<input type="submit" name="BeASeller" class="btn btn-danger" value="Oui">
						<input type="button" name="Non" class="btn btn-success" value="Non" onclick="Close('seller')">
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		function Open(value) {			
			if (value == 'delete') {
				document.getElementById('askDeleteBackground').style.display = 'block';
			} else if (value == 'seller') {
				document.getElementById('askBecomeSeller').style.display = 'block';
			}
		}

		function Close(value) {
			if (value == 'delete') {
				document.getElementById('askDeleteBackground').style.display = 'none';
			} else if (value == 'seller') {
				document.getElementById('askBecomeSeller').style.display = 'none';
			}
		}
	</script>


</body>

</html>
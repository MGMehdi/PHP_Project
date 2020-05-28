<?php
include 'components/header.php';
include 'components/nav.php';
include '../objects/database.php';
$db = new Database();
$cities = $db->GetAllCities();

$action = '';
$entreprises = $db->GetMyEntreprises($_SESSION['id']);

if (isset($_POST['NewEntreprise'])) {
	header('Location: addentreprise.php');
}

if (isset($_POST['modify'])) {
	$_SESSION['idEntreprise'] = $_POST['idEntreprise'];
	header('Location: updateEntreprise.php');
}

if (isset($_POST['Oui'])) {
	$db->DeleteEntreprise($_POST['idEntreprise']);
	header("Refresh:0");
}
?>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/style.css">
	<title>Mes entreprises</title>
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2 text-center">
				<form action="myentreprise.php" method="post">
					<input type="submit" class="btn btn-secondary" value="Nouvelle entreprise" name="NewEntreprise">
				</form>
			</div>
			<div class="col-sm-10">
				<table class="table text-center">
					<thead>
						<th scope="col">Nom</th>
						<th scope="col">Adresse</th>
						<th scope="col">Produit</th>
						<th scope="col">Contact</th>
						<th scope="col">Action</th>
					</thead>
					<tbody>
						<?php foreach ($entreprises as $entreprise) { ?>
							<tr>
								<td><?php echo ($entreprise->getName()) ?></td>
								<td><?php echo ($entreprise->getAddress()) ?></td>
								<td><?php echo ($entreprise->getProduct()) ?></td>
								<td><?php echo ($entreprise->getPhone()) ?></td>
								<td>
									<form action="myentreprise.php" method="post">
										<button type="button" name="delete" onclick="Delete(<?php echo $entreprise->getId() ?>)"><img src="../images/delete.svg" alt="" srcset="" style="width: 2em;"></button>
										<button type=" submit" name="modify" value="Modify"><img src="../images/edit.svg" style="width: 2em;"></button>
										<input hidden type="number" name="idEntreprise" value="<?php echo $entreprise->getId() ?>">
									</form>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>

		<div id="cardBackground" class="text-center" onclick="Close()"></div>
		<div id="deleteCard" class="card" style="width: 40rem;">
			<div class="card-body">
				<h3 class="card-title">Supprimer ?</h3>
				<h5>Etes vous sûr de vouloir supprimer cette entrepreprise ?</h5>
				<form action="myentreprise.php" method="post">
					<input type="number" name="idEntreprise" hidden value="<?php echo $entreprise->getId() ?>">
					<input type="submit" name="Oui" class="btn btn-danger" value="Oui">
					<input type="button" name="Non" class="btn btn-success" value="Non" onclick="Close()">
				</form>
			</div>
		</div>

		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
	</div>

	<script>
		function Delete() {
			document.getElementById('cardBackground').style.display = 'block';
			document.getElementById('deleteCard').style.display = 'block';
		}

		function Close() {
			document.getElementById('cardBackground').style.display = 'none';
			document.getElementById('deleteCard').style.display = 'none';
		}
	</script>

</body>

</html>
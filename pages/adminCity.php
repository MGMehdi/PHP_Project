<?php
include 'components/header.php';
include 'components/nav.php';
include '../objects/user.php';
include '../objects/database.php';

if (empty($_SESSION['surname']) || $_SESSION['admin']==0) {
	header('Location: home.php');
}

$db = new Database();
$cities = $db->GetAllCities();

if (isset($_POST['update'])) {
	$city = new City($_POST['Id'], $_POST['City'], $_POST['Province']);
	$db->UpdateCity($city);
	header('Location: adminCity.php');
}
if (isset($_POST['add'])) {
	$city = new City($_POST['Id'], $_POST['City'], $_POST['Province']);
	$db->addCity($city);
	header('Location: adminCity.php');
}
if (isset($_POST['Oui'])) {
	$db->DeleteCity($_POST['idCity']);
	header("Location: adminCity.php");
}
?>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/style.css">
	<title>Modifier les villes</title>
</head>

<body>

	<div class="container-fluid">
		<h1>Modification des villes</h1>
		<div class="row justify-content-center">
			<div class="col-sm-1 text-center">
				<input type="button" class="btn btn-success" value="Ajouter une ville" onclick="addCity()">
			</div>
			<div class="col-sm-11">
				<table class="table text-center">
					<thead>
						<th scope="col">Ville</th>
						<th scope="col">Région</th>
						<th scope="col">Actions</th>
					</thead>
					<tbody>
						<?php foreach ($cities as $city) { ?>
							<tr>
								<td><?php echo htmlspecialchars($city->getCity()) ?></td>
								<td><?php echo htmlspecialchars($city->getProvince()) ?></td>
								<td>
									<form action="adminCity.php" method="post">
										<button type="button" name="delete" onclick="Delete('<?php echo $city->getId() ?>')" style='background:none;border:none;padding:0'><img src="../images/delete.svg" width="40" height="40"></button>
										<button type="button" name="modify" value="Modify" style='background:none;border:none;padding:0' onclick="Open(`<?php echo $city->getId() ?>`, `<?php echo htmlspecialchars($city->getCity()) ?>`, `<?php echo htmlspecialchars($city->getProvince()) ?>`)"><img src="../images/edit.svg" width="40" height="40"></button>
										<input hidden type="number" name="idEntreprise" value="<?php echo $city->getId() ?>">
									</form>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>

		<div id="cardBackground" onclick="Close()"></div>
		<div id="updateCard" class="card text-center">
			<div class="card-body">
				<form action="adminCity.php" method="post">
					<h3 class="card-title" id="card-title">Modifier</h3>
					<label for="City">Ville</label>
					<input type="text" class="form-control" name="City" id="City">
					<label for="Province">Province</label>
					<input type="text" class="form-control" name="Province" id="Province">
					<input type="text" hidden name="Id" id="Id">
					<input type="submit" name="update" class="btn btn-danger" value="Oui">
					<input type="button" class="btn btn-success" value="Non" onclick="Close()">
				</form>
			</div>
		</div>
		<div id="addCity" class="card text-center">
			<div class="card-body">
				<form action="adminCity.php" method="post">
					<h3 class="card-title" id="card-title">Ajouter</h3>
					<label for="City">Ville</label>
					<input type="text" class="form-control" name="City" id="City">
					<label for="Province">Province</label>
					<input type="text" class="form-control" name="Province" id="Province">
					<input type="text" hidden name="Id" id="Id">
					<input type="submit" name="add" class="btn btn-danger" value="Oui">
					<input type="button" class="btn btn-success" value="Non" onclick="Close()">
				</form>
			</div>
		</div>
		<div id="deleteCard" class="card text-center">
			<div class="card-body">
				<h3 class="card-title">Supprimer ?</h3>
				<h5>Etes vous sûr de vouloir supprimer cette ville ?</h5>
				<form action="adminCity.php" method="post">
					<input type="number" name="idCity" hidden value="<?php echo $city->getId() ?>">
					<input type="submit" name="Oui" class="btn btn-danger" value="Oui">
					<input type="button" name="Non" class="btn btn-success" value="Non" onclick="Close()">
				</form>
			</div>
		</div>
	</div>

	<script>
		function Open(id, city, province) {
			document.getElementById('Id').value = id
			document.getElementById('City').value = city
			document.getElementById('Province').value = province
			document.getElementById('cardBackground').style.display = 'block';
			document.getElementById('updateCard').style.display = 'block';
		}

		function Close() {
			document.getElementById('cardBackground').style.display = 'none';
			document.getElementById('updateCard').style.display = 'none';
			document.getElementById('deleteCard').style.display = 'none';
		}

		function addCity() {
			document.getElementById('cardBackground').style.display = 'block';
			document.getElementById('addCity').style.display = 'block';
		}

		function Delete(id) {
			document.getElementById('cardBackground').style.display = 'block';
			document.getElementById('deleteCard').style.display = 'block';
		}
	</script>

</body>

</html>
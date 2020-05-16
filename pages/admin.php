<?php
include 'components/header.php';
include 'components/nav.php';
include '../objects/user.php';
include '../objects/database.php';

$db = new Database();
$newSellers = $db->GetAllNewSeller();
error_log(json_encode($newSellers));

if (isset($_POST['Ok'])) {
	error_log(isset($_POST['seller']));
}

?>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/style.css">
	<title>Panneau d'administration</title>
</head>

<body>
	<h1>Demande pour devenir un vendeur</h1>
	<form action="admin.php" method="post">
		<table class="table text-center">
			<thead>
				<th scope="col">Nom</th>
				<th scope="col">Prénom</th>
				<th scope="col">Mail</th>
				<th scope="col">Vendeur</th>
			</thead>
			<tbody>
				<?php foreach ($newSellers as $key => $newSeller) { ?>
					<tr>
						<td><?php echo ($newSeller->getName()) ?></td>
						<td><?php echo ($newSeller->getSurname()) ?></td>
						<td><?php echo ($newSeller->getMail()) ?></td>
						<td>
							<select name="seller" id="SelectType" onchange="setValue(<?php echo ($key) ?>)">
								<option value="5">Refusé</option>
								<option value="1">Accepté</option>
								<option value="2" selected>En attende</option>
							</select>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<button type='submit' name='Ok' value='Validé' style='background:none;border:none;padding:0'><img src='../images/0.svg' width="40" height="40"></button>
	</form>

	<script>
		console.log('coucou');
		
		var users = <?php echo json_encode($newSellers); ?>;

		console.log(users);
		// Le seul truc qui "fonctionnait" 
		// J'ai regardé sur stackoverflow mais c'est avec php 5 mdr les réponses... 2011
		// Att j'ai un pote qui fais du dev web

		function setValue(id) {

		}
	</script>

</body>

</html>
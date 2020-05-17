<?php
include 'components/header.php';
include 'components/nav.php';
include '../objects/user.php';
include '../objects/database.php';

$db = new Database();
$newSellers = $db->GetAllNewSeller();

if (isset($_POST['users'])) {
	$users = json_decode(stripslashes($_POST['users']));
	foreach ($users as $user) {
		$u = new User($user->id, '', '', '', '', '', $user->seller);
		$db->beASeller($u);
	}
}

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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<title>Panneau d'administration</title>
</head>

<body>
	<h1>Demande pour devenir un vendeur</h1>
	<form action="adminSeller.php" method="post">
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
							<select name="seller" id="<?php echo ($key) ?>" onchange="setValue(<?php echo ($key) ?>)">
								<option value="5">Refusé</option>
								<option value="1">Accepté</option>
								<option value="2" selected>En attende</option>
							</select>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<button type='submit' name='Ok' value='Validé' style='background:none;border:none;padding:0' onclick="Submit()"><img src='../images/0.svg' width="40" height="40"></button>
	</form>

	<script>
		console.log('coucou');
		var users = [];
		var user = null;
		<?php
		foreach ($newSellers as $key => $newSeller) {
			echo "user = {id:'" . $newSeller->getId() . "', name:'" . $newSeller->getName() . "', surname:'" . $newSeller->getSurname() . "', mail: '" . $newSeller->getMail() . "',seller:'" . $newSeller->getSeller() . "'};\n";
			echo "users.push(user);\n";
		}
		?>

		function setValue(id) {
			users[id].seller = document.getElementById(id).value;
			console.log(users[id]);
		}

		function Submit() {
			$.post('adminSeller.php', {users: JSON.stringify(users)});
		}
	</script>

</body>

</html>
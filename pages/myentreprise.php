<?php
include 'components/header.php';
include 'components/nav.php';
include '../objects/database.php';
$db = new Database();

$entreprises = $db->GetMyEntreprises($_SESSION['id']);

if (isset($_POST['NewEntreprise'])) {
    header('Location: addentreprise.php');
}

if (isset($_POST['delete'])) {
    header('Location: home.php');
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
                                <td><?php echo htmlspecialchars($entreprise->getName()) ?></td>
                                <td><?php echo htmlspecialchars($entreprise->getAddress()) ?></td>
                                <td><?php echo htmlspecialchars($entreprise->getProduct()) ?></td>
                                <td><?php echo htmlspecialchars($entreprise->getPhone()) ?></td>
                                <td>
                                    <form action="myentreprise.php" method="post">
                                        <button name="delete" value="delete" style="background: none; border: none;outline: inherit"><img src="../images/delete.svg" style="width: 2em;"></button>
                                        <button name="edit" value="edit" style="background: none; border: none;outline: inherit"><img src="../images/edit.svg" style="width: 2em;"></button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>